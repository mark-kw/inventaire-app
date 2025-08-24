<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250824230456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE audit_logs (id BIGINT AUTO_INCREMENT NOT NULL, actor_id INT DEFAULT NULL, entity VARCHAR(60) NOT NULL, entity_id CHAR(36) DEFAULT NULL COMMENT '(DC2Type:uuid)', action VARCHAR(40) NOT NULL, payload JSON DEFAULT NULL COMMENT '(DC2Type:json)', created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_D62F285810DAF24A (actor_id), INDEX idx_audit_entity (entity, entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE guest (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(80) NOT NULL, last_name VARCHAR(80) NOT NULL, email VARCHAR(160) DEFAULT NULL, phone VARCHAR(40) DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, id_type VARCHAR(40) DEFAULT NULL, id_number VARCHAR(80) DEFAULT NULL, special_requests LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE housekeeping_log (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, changed_by_id INT DEFAULT NULL, status_from VARCHAR(255) DEFAULT NULL, status_to VARCHAR(255) NOT NULL, note LONGTEXT DEFAULT NULL, changed_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_7311E0C854177093 (room_id), INDEX IDX_7311E0C8828AD0A0 (changed_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE maintenance_tasks (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, title VARCHAR(160) NOT NULL, description LONGTEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', resolved_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_C245F86C54177093 (room_id), INDEX IDX_C245F86CB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, amount VARCHAR(255) NOT NULL, currency VARCHAR(3) NOT NULL, reference VARCHAR(120) NOT NULL, paid_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, guest_id INT NOT NULL, room_id INT NOT NULL, code VARCHAR(18) NOT NULL, arrival_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', departure_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', adults SMALLINT NOT NULL, children SMALLINT NOT NULL, total_amount NUMERIC(12, 2) NOT NULL, xof DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', checkout_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', notes LONGTEXT DEFAULT NULL, INDEX IDX_42C849559A4AA658 (guest_id), INDEX IDX_42C8495554177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, number VARCHAR(20) NOT NULL, name VARCHAR(120) DEFAULT NULL, capacity_adults SMALLINT NOT NULL, capacity_children SMALLINT NOT NULL, night_price NUMERIC(12, 2) NOT NULL, currency VARCHAR(3) NOT NULL, INDEX IDX_729F519BC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE room_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(120) NOT NULL, email VARCHAR(160) NOT NULL, password_hash VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE audit_logs ADD CONSTRAINT FK_D62F285810DAF24A FOREIGN KEY (actor_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE housekeeping_log ADD CONSTRAINT FK_7311E0C854177093 FOREIGN KEY (room_id) REFERENCES room (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE housekeeping_log ADD CONSTRAINT FK_7311E0C8828AD0A0 FOREIGN KEY (changed_by_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE maintenance_tasks ADD CONSTRAINT FK_C245F86C54177093 FOREIGN KEY (room_id) REFERENCES room (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE maintenance_tasks ADD CONSTRAINT FK_C245F86CB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT FK_42C849559A4AA658 FOREIGN KEY (guest_id) REFERENCES guest (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT FK_42C8495554177093 FOREIGN KEY (room_id) REFERENCES room (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE room ADD CONSTRAINT FK_729F519BC54C8C93 FOREIGN KEY (type_id) REFERENCES room_type (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE audit_logs DROP FOREIGN KEY FK_D62F285810DAF24A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE housekeeping_log DROP FOREIGN KEY FK_7311E0C854177093
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE housekeeping_log DROP FOREIGN KEY FK_7311E0C8828AD0A0
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE maintenance_tasks DROP FOREIGN KEY FK_C245F86C54177093
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE maintenance_tasks DROP FOREIGN KEY FK_C245F86CB03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY FK_42C849559A4AA658
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495554177093
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE room DROP FOREIGN KEY FK_729F519BC54C8C93
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE audit_logs
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE guest
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE housekeeping_log
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE maintenance_tasks
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE payment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reservation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE room
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE room_type
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
    }
}
