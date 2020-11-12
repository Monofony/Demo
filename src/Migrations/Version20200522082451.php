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
final class Version20200522082451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_animal ADD taxon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE app_animal ADD CONSTRAINT FK_8FA84E9FDE13F470 FOREIGN KEY (taxon_id) REFERENCES sylius_taxon (id)');
        $this->addSql('CREATE INDEX IDX_8FA84E9FDE13F470 ON app_animal (taxon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_animal DROP FOREIGN KEY FK_8FA84E9FDE13F470');
        $this->addSql('DROP INDEX IDX_8FA84E9FDE13F470 ON app_animal');
        $this->addSql('ALTER TABLE app_animal DROP taxon_id');
    }
}
