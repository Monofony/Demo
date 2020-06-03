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
final class Version20200603143835 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_booking DROP FOREIGN KEY FK_D516D938E962C16');
        $this->addSql('DROP INDEX IDX_D516D938E962C16 ON app_booking');
        $this->addSql('ALTER TABLE app_booking CHANGE animal_id pet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE app_booking ADD CONSTRAINT FK_D516D93966F7FB6 FOREIGN KEY (pet_id) REFERENCES app_animal (id)');
        $this->addSql('CREATE INDEX IDX_D516D93966F7FB6 ON app_booking (pet_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_booking DROP FOREIGN KEY FK_D516D93966F7FB6');
        $this->addSql('DROP INDEX IDX_D516D93966F7FB6 ON app_booking');
        $this->addSql('ALTER TABLE app_booking CHANGE pet_id animal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE app_booking ADD CONSTRAINT FK_D516D938E962C16 FOREIGN KEY (animal_id) REFERENCES app_animal (id)');
        $this->addSql('CREATE INDEX IDX_D516D938E962C16 ON app_booking (animal_id)');
    }
}
