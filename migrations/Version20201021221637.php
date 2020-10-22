<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201021221637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT fk_723705d1d834b30f');
        $this->addSql('DROP INDEX idx_723705d1d834b30f');
        $this->addSql('ALTER TABLE transaction RENAME COLUMN credit_transaction_id TO credit_account_id');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D16813E404 FOREIGN KEY (credit_account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_723705D16813E404 ON transaction (credit_account_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D16813E404');
        $this->addSql('DROP INDEX IDX_723705D16813E404');
        $this->addSql('ALTER TABLE transaction RENAME COLUMN credit_account_id TO credit_transaction_id');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT fk_723705d1d834b30f FOREIGN KEY (credit_transaction_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_723705d1d834b30f ON transaction (credit_transaction_id)');
    }
}
