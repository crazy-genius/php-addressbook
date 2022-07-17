<?php

include "include/configure.php";
include "include/export.vcard.php";
include "include/view.w.php";

function br2nl($string)
{
    return str_replace(['<br>', '<br >', '<Br>', '<BR>', '<BR >', '<br/>', '<br />'], "\r\n", $string);
}

function flattenParts($messageParts, $flattenedParts = [], $prefix = '', $index = 1, $fullPrefix = true)
{

    foreach ($messageParts as $part) {
        $flattenedParts[$prefix . $index] = $part;
        if (isset($part->parts)) {
            if ($part->type == 2) {
                $flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix . $index . '.', 0, false);
            } elseif ($fullPrefix) {
                $flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix . $index . '.');
            } else {
                $flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix);
            }
            unset($flattenedParts[$prefix . $index]->parts);
        }
        $index++;
    }

    return $flattenedParts;
}

function getPart($connection, $messageNumber, $partNumber, $encoding)
{

    $data = imap_fetchbody($connection, $messageNumber, $partNumber);

    return match ($encoding) {
        3 => base64_decode($data),
        4 => imap_qprint($data),
        default => $data,
    };
}

$connection = imap_open($mail_box, $mail_user, $mail_pass, !OP_SECURE) or die("Error: " . imap_last_error());
$MC = imap_check($connection);
$messageNumber = $MC->Nmsgs;
if ($messageNumber == 0) {
    die;
}

//
// Check last mail
//
$hds = imap_headerinfo($connection, $messageNumber);
echo nl2br(print_r($hds, true));

// Check if mail is authorized
$to = $hds->from[0]->mailbox . "@" . $hds->from[0]->host;
if (count($mail_accept) > 0 && !in_array($to, $mail_accept, true)) {
    // delete without warning
    imap_delete($connection, "$messageNumber");

// process next mail
    die;
}

//
// Process last mail
//
$structure = imap_fetchstructure($connection, $messageNumber);

if (isset($structure->parts)) {
    $flattenedParts = flattenParts($structure->parts);
} else {
    $flattenedParts[1] = $structure;
}

foreach ($flattenedParts as $partNumber => $part) {

    switch ($part->type) {
        case 0:
            $message = getPart($connection, $messageNumber, $partNumber, $part->encoding);


            foreach ($part->parameters as $parameter) {
                if (strtoupper($parameter->attribute) === "CHARSET") {
                    $charset = $parameter->value;
                    echo "<br>$charset<br>";
                    if (function_exists('mb_convert_encoding')) {
                        $message = mb_convert_encoding($message, "UTF-8", strtoupper($charset));
                    } else {
                        $message = utf8_encode($message);
                    }
                }
            }

            if ($part->subtype === "HTML") {
                $message = br2nl($message);
                // ToDo: strip "<style>" section
                // ToDo: strip "<javascript>" section
                $message = strip_tags($message);
                $message = html_entity_decode($message, ENT_COMPAT, "UTF-8");
            }

            break;
        case 1: # multi-part headers,       ignore
        case 2: # attached message headers, ignore
        case 3: # application,              ignore
        case 4: # audio
        case 5: # image
        case 6: # video
            break;
        case 7: # other
            // $filename = getFilenameFromPart($part);
            $filename = "";
            if ($filename) { # it's an attachment

                $attachment = getPart($connection, $messageNumber, $partNumber, $part->encoding);
                // now do something with the attachment, e.g. save it somewhere

                # It's a vcard
                // ...
            }
            break;
    }
}

$addr = guessAddressFields($message);

// Generate vCard
$vcard = address2vcard($addr);

// Generate mail body
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ob_start();
showOneEntry($addr);
$mail_text = ob_get_clean();


//------------------ Sending the e-Mail
$subject = "vCard for: " . $addr['firstname'] . (isset($addr['middlename']) ? " " . $addr['middlename'] : "") . " " . $addr['lastname'] . (isset($addr['company']) ? " (" . $addr['company'] . ")" : "");
$boundary = md5(date('r', time()));

// Define Headers we want passed:
// *  Note that they are separated with \r\n
$headers = "From: " . $mail_user . "\r\nReply-To: " . $mail_user;
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-" . $boundary . "\"";

$body = "--PHP-mixed-" . $boundary . "\r\n";
$body .= "Content-Type: text/html; charset=\"utf-8\"";
$body .= "\r\nContent-Transfer-Encoding: 8bit";
$body .= "\r\n\r\n";
$body .= $mail_text;
$body .= "\r\n\r\n";
$body .= "--PHP-mixed-" . $boundary . "\r\n";
$body .= implode("\r\n", headers2vcard($addr));
$body .= "\r\n\r\n";
$body .= $vcard;
$body .= "--PHP-mixed-" . $boundary . "\r\n";

$mail_sent = mail($to, $subject, $body, $headers);

if (imap_mail_move($connection, "$messageNumber", "INBOX.Processed")) {

    echo "Mail moved " . $to;
}
imap_expunge($connection);

