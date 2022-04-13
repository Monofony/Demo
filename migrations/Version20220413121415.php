<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220413121415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE booking_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE booking (id INT NOT NULL, pet_id INT DEFAULT NULL, booker_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E00CEDDE966F7FB6 ON booking (pet_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE8B7E4006 ON booking (booker_id)');
        $this->addSql('COMMENT ON COLUMN booking.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE8B7E4006 FOREIGN KEY (booker_id) REFERENCES sylius_customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE booking_id_seq CASCADE');
        $this->addSql('DROP TABLE booking');
    }
}
