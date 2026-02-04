<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260204134003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE audit (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, invoice_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, reference VARCHAR(30) NOT NULL, declared_perimetre VARCHAR(100) NOT NULL, synthesis LONGTEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_9218FF7919EB6921 (client_id), INDEX IDX_9218FF792989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certification (id INT AUTO_INCREMENT NOT NULL, invoice_id INT DEFAULT NULL, status VARCHAR(20) NOT NULL, title VARCHAR(100) NOT NULL, price NUMERIC(5, 2) NOT NULL, file_path VARCHAR(100) DEFAULT NULL, INDEX IDX_6C3C6D752989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, siret VARCHAR(50) NOT NULL, adress VARCHAR(150) NOT NULL, city VARCHAR(100) NOT NULL, postal_code VARCHAR(20) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, reference VARCHAR(50) NOT NULL, date DATETIME NOT NULL, price NUMERIC(5, 2) NOT NULL, status VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_9065174419EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, client_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, phone VARCHAR(20) DEFAULT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', last_login DATETIME DEFAULT NULL, INDEX IDX_8D93D649D60322AC (role_id), UNIQUE INDEX UNIQ_8D93D64919EB6921 (client_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_audit (user_id INT NOT NULL, audit_id INT NOT NULL, INDEX IDX_70DA0421A76ED395 (user_id), INDEX IDX_70DA0421BD29F359 (audit_id), PRIMARY KEY(user_id, audit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_certification (user_id INT NOT NULL, certification_id INT NOT NULL, INDEX IDX_82B2C025A76ED395 (user_id), INDEX IDX_82B2C025CB47068A (certification_id), PRIMARY KEY(user_id, certification_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF7919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF792989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE certification ADD CONSTRAINT FK_6C3C6D752989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_9065174419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE user_audit ADD CONSTRAINT FK_70DA0421A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_audit ADD CONSTRAINT FK_70DA0421BD29F359 FOREIGN KEY (audit_id) REFERENCES audit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_certification ADD CONSTRAINT FK_82B2C025A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_certification ADD CONSTRAINT FK_82B2C025CB47068A FOREIGN KEY (certification_id) REFERENCES certification (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audit DROP FOREIGN KEY FK_9218FF7919EB6921');
        $this->addSql('ALTER TABLE audit DROP FOREIGN KEY FK_9218FF792989F1FD');
        $this->addSql('ALTER TABLE certification DROP FOREIGN KEY FK_6C3C6D752989F1FD');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_9065174419EB6921');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64919EB6921');
        $this->addSql('ALTER TABLE user_audit DROP FOREIGN KEY FK_70DA0421A76ED395');
        $this->addSql('ALTER TABLE user_audit DROP FOREIGN KEY FK_70DA0421BD29F359');
        $this->addSql('ALTER TABLE user_certification DROP FOREIGN KEY FK_82B2C025A76ED395');
        $this->addSql('ALTER TABLE user_certification DROP FOREIGN KEY FK_82B2C025CB47068A');
        $this->addSql('DROP TABLE audit');
        $this->addSql('DROP TABLE certification');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_audit');
        $this->addSql('DROP TABLE user_certification');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
