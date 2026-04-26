<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260426071002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conference (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, location VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE registration (id INT AUTO_INCREMENT NOT NULL, register_date DATE NOT NULL, status VARCHAR(50) NOT NULL, user_id INT DEFAULT NULL, session_id INT DEFAULT NULL, INDEX IDX_62A8A7A7A76ED395 (user_id), INDEX IDX_62A8A7A7613FECDF (session_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, room_name VARCHAR(255) NOT NULL, capacity INT NOT NULL, building VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, session_date DATE NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, conference_id INT DEFAULT NULL, speaker_id INT DEFAULT NULL, room_id INT DEFAULT NULL, INDEX IDX_D044D5D4604B8382 (conference_id), INDEX IDX_D044D5D4D04A0F27 (speaker_id), INDEX IDX_D044D5D454177093 (room_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE speaker (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, topic VARCHAR(255) NOT NULL, biography LONGTEXT NOT NULL, photo VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4604B8382 FOREIGN KEY (conference_id) REFERENCES conference (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4D04A0F27 FOREIGN KEY (speaker_id) REFERENCES speaker (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D454177093 FOREIGN KEY (room_id) REFERENCES room (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A7A76ED395');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A7613FECDF');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4604B8382');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4D04A0F27');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D454177093');
        $this->addSql('DROP TABLE conference');
        $this->addSql('DROP TABLE registration');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE speaker');
        $this->addSql('DROP TABLE user');
    }
}
