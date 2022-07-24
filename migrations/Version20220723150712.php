<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220723150712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address_in_groups DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE address_in_groups CHANGE id id INT UNSIGNED NOT NULL, CHANGE group_id group_id INT UNSIGNED NOT NULL, CHANGE domain_id domain_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE address_in_groups ADD PRIMARY KEY (id, group_id)');
        $this->addSql('ALTER TABLE addressbook CHANGE domain_id domain_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE group_list MODIFY group_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE group_list DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE group_list CHANGE domain_id domain_id INT UNSIGNED NOT NULL, CHANGE group_id group_id INT UNSIGNED NOT NULL, CHANGE group_name group_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE group_list ADD PRIMARY KEY (domain_id, group_id)');
        $this->addSql('ALTER TABLE month_lookup CHANGE bmonth_num bmonth_num INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE bmonth bmonth VARCHAR(50) NOT NULL, CHANGE bmonth_short bmonth_short CHAR(3) NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE domain_id domain_id INT UNSIGNED NOT NULL, CHANGE password_hint password_hint VARCHAR(255) NOT NULL, CHANGE lastname lastname VARCHAR(50) NOT NULL, CHANGE firstname firstname VARCHAR(50) NOT NULL, CHANGE email email VARCHAR(100) NOT NULL, CHANGE phone phone VARCHAR(50) NOT NULL, CHANGE address1 address1 VARCHAR(100) NOT NULL, CHANGE address2 address2 VARCHAR(100) NOT NULL, CHANGE city city VARCHAR(80) NOT NULL, CHANGE state state VARCHAR(20) NOT NULL, CHANGE zip zip VARCHAR(20) NOT NULL, CHANGE country country VARCHAR(50) NOT NULL, CHANGE trials trials INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address_in_groups DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE address_in_groups CHANGE id id INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE group_id group_id INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE domain_id domain_id INT UNSIGNED DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE address_in_groups ADD PRIMARY KEY (group_id, id)');
        $this->addSql('ALTER TABLE addressbook CHANGE domain_id domain_id INT UNSIGNED DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE group_list DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE group_list CHANGE domain_id domain_id INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE group_id group_id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE group_name group_name VARCHAR(255) DEFAULT \'\' NOT NULL');
        $this->addSql('ALTER TABLE group_list ADD PRIMARY KEY (group_id, domain_id)');
        $this->addSql('ALTER TABLE month_lookup CHANGE bmonth_num bmonth_num INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE bmonth bmonth VARCHAR(50) DEFAULT \'\' NOT NULL, CHANGE bmonth_short bmonth_short CHAR(3) DEFAULT \'\' NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE domain_id domain_id INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE password_hint password_hint VARCHAR(255) DEFAULT \'\' NOT NULL, CHANGE lastname lastname VARCHAR(50) DEFAULT \'\' NOT NULL, CHANGE firstname firstname VARCHAR(50) DEFAULT \'\' NOT NULL, CHANGE email email VARCHAR(100) DEFAULT \'\' NOT NULL, CHANGE phone phone VARCHAR(50) DEFAULT \'\' NOT NULL, CHANGE address1 address1 VARCHAR(100) DEFAULT \'\' NOT NULL, CHANGE address2 address2 VARCHAR(100) DEFAULT \'\' NOT NULL, CHANGE city city VARCHAR(80) DEFAULT \'\' NOT NULL, CHANGE state state VARCHAR(20) DEFAULT \'\' NOT NULL, CHANGE zip zip VARCHAR(20) DEFAULT \'\' NOT NULL, CHANGE country country VARCHAR(50) DEFAULT \'\' NOT NULL, CHANGE trials trials INT DEFAULT 0 NOT NULL');
    }
}
