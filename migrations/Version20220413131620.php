<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220413131620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE sylius_taxon_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sylius_taxon_translation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE sylius_taxon (id INT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, tree_left INT NOT NULL, tree_right INT NOT NULL, tree_level INT NOT NULL, position INT NOT NULL, enabled BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CFD811CA77153098 ON sylius_taxon (code)');
        $this->addSql('CREATE INDEX IDX_CFD811CAA977936C ON sylius_taxon (tree_root)');
        $this->addSql('CREATE INDEX IDX_CFD811CA727ACA70 ON sylius_taxon (parent_id)');
        $this->addSql('CREATE TABLE sylius_taxon_translation (id INT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1487DFCF2C2AC5D3 ON sylius_taxon_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX slug_uidx ON sylius_taxon_translation (locale, slug)');
        $this->addSql('CREATE UNIQUE INDEX sylius_taxon_translation_uniq_trans ON sylius_taxon_translation (translatable_id, locale)');
        $this->addSql('ALTER TABLE sylius_taxon ADD CONSTRAINT FK_CFD811CAA977936C FOREIGN KEY (tree_root) REFERENCES sylius_taxon (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sylius_taxon ADD CONSTRAINT FK_CFD811CA727ACA70 FOREIGN KEY (parent_id) REFERENCES sylius_taxon (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sylius_taxon_translation ADD CONSTRAINT FK_1487DFCF2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES sylius_taxon (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sylius_taxon DROP CONSTRAINT FK_CFD811CAA977936C');
        $this->addSql('ALTER TABLE sylius_taxon DROP CONSTRAINT FK_CFD811CA727ACA70');
        $this->addSql('ALTER TABLE sylius_taxon_translation DROP CONSTRAINT FK_1487DFCF2C2AC5D3');
        $this->addSql('DROP SEQUENCE sylius_taxon_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sylius_taxon_translation_id_seq CASCADE');
        $this->addSql('DROP TABLE sylius_taxon');
        $this->addSql('DROP TABLE sylius_taxon_translation');
    }
}
