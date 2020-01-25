<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200125204309 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE transactions (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', source_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', target_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', amount BIGINT UNSIGNED NOT NULL, occurred_at DATETIME NOT NULL, INDEX IDX_EAA81A4C953C1C61 (source_id), INDEX IDX_EAA81A4C158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', wallet_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', username VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), UNIQUE INDEX UNIQ_1483A5E9712520F3 (wallet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallets (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', transfer_participant_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', amount BIGINT UNSIGNED NOT NULL, UNIQUE INDEX UNIQ_967AAA6CCC64F8 (transfer_participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transfer_participants (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', wallet_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', type VARCHAR(255) NOT NULL, INDEX IDX_3FB4FF51712520F3 (wallet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C953C1C61 FOREIGN KEY (source_id) REFERENCES transfer_participants (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C158E0B66 FOREIGN KEY (target_id) REFERENCES transfer_participants (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9712520F3 FOREIGN KEY (wallet_id) REFERENCES wallets (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wallets ADD CONSTRAINT FK_967AAA6CCC64F8 FOREIGN KEY (transfer_participant_id) REFERENCES transfer_participants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transfer_participants ADD CONSTRAINT FK_3FB4FF51712520F3 FOREIGN KEY (wallet_id) REFERENCES wallets (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9712520F3');
        $this->addSql('ALTER TABLE transfer_participants DROP FOREIGN KEY FK_3FB4FF51712520F3');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C953C1C61');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C158E0B66');
        $this->addSql('ALTER TABLE wallets DROP FOREIGN KEY FK_967AAA6CCC64F8');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE wallets');
        $this->addSql('DROP TABLE transfer_participants');
    }
}
