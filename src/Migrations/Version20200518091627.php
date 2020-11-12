<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200518091627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sylius_taxon (id INT AUTO_INCREMENT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, tree_left INT NOT NULL, tree_right INT NOT NULL, tree_level INT NOT NULL, position INT NOT NULL, UNIQUE INDEX UNIQ_CFD811CA77153098 (code), INDEX IDX_CFD811CAA977936C (tree_root), INDEX IDX_CFD811CA727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_animal_image (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_2640C72A8E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_animal (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, description LONGTEXT DEFAULT NULL, size NUMERIC(10, 0) DEFAULT NULL, size_unit VARCHAR(255) DEFAULT NULL, main_color VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8FA84E9F989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_taxon_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_1487DFCF2C2AC5D3 (translatable_id), UNIQUE INDEX slug_uidx (locale, slug), UNIQUE INDEX sylius_taxon_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sylius_taxon ADD CONSTRAINT FK_CFD811CAA977936C FOREIGN KEY (tree_root) REFERENCES sylius_taxon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_taxon ADD CONSTRAINT FK_CFD811CA727ACA70 FOREIGN KEY (parent_id) REFERENCES sylius_taxon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE app_animal_image ADD CONSTRAINT FK_2640C72A8E962C16 FOREIGN KEY (animal_id) REFERENCES app_animal (id)');
        $this->addSql('ALTER TABLE sylius_taxon_translation ADD CONSTRAINT FK_1487DFCF2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES sylius_taxon (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_taxon DROP FOREIGN KEY FK_CFD811CAA977936C');
        $this->addSql('ALTER TABLE sylius_taxon DROP FOREIGN KEY FK_CFD811CA727ACA70');
        $this->addSql('ALTER TABLE sylius_taxon_translation DROP FOREIGN KEY FK_1487DFCF2C2AC5D3');
        $this->addSql('ALTER TABLE app_animal_image DROP FOREIGN KEY FK_2640C72A8E962C16');
        $this->addSql('DROP TABLE sylius_taxon');
        $this->addSql('DROP TABLE app_animal_image');
        $this->addSql('DROP TABLE app_animal');
        $this->addSql('DROP TABLE sylius_taxon_translation');
    }
}
