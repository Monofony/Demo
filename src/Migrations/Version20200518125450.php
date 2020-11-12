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
final class Version20200518125450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_booking (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, validate_at DATE NOT NULL, INDEX IDX_D516D938E962C16 (animal_id), INDEX IDX_D516D939395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_booking ADD CONSTRAINT FK_D516D938E962C16 FOREIGN KEY (animal_id) REFERENCES app_animal (id)');
        $this->addSql('ALTER TABLE app_booking ADD CONSTRAINT FK_D516D939395C3F3 FOREIGN KEY (customer_id) REFERENCES sylius_customer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE app_booking');
    }
}
