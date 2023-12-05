<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204221118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE circuit DROP FOREIGN KEY circuit_ibfk_1');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY fk_Commentaire_post');
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY fk_categorie');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY fk_evenement_reservation');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE circuit');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE destination');
        $this->addSql('DROP TABLE evenements');
        $this->addSql('DROP TABLE participants');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE transport');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX idU ON reclamation');
        $this->addSql('DROP INDEX emailU ON reclamation');
        $this->addSql('ALTER TABLE reclamation CHANGE intitule intitule VARCHAR(500) NOT NULL, CHANGE emailU emailu VARCHAR(500) NOT NULL');
        $this->addSql('DROP INDEX Prenom ON reponsereclamation');
        $this->addSql('DROP INDEX idU ON reponsereclamation');
        $this->addSql('DROP INDEX textRec ON reponsereclamation');
        $this->addSql('ALTER TABLE reponsereclamation DROP FOREIGN KEY reponsereclamation_ibfk_1');
        $this->addSql('ALTER TABLE reponsereclamation CHANGE Prenom prenom VARCHAR(500) NOT NULL, CHANGE idRec idRec INT DEFAULT NULL');
        $this->addSql('DROP INDEX idrec ON reponsereclamation');
        $this->addSql('CREATE INDEX IDX_B052BA70454DD7AB ON reponsereclamation (idRec)');
        $this->addSql('ALTER TABLE reponsereclamation ADD CONSTRAINT reponsereclamation_ibfk_1 FOREIGN KEY (idRec) REFERENCES reclamation (idRec)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE circuit (id INT AUTO_INCREMENT NOT NULL, destination_id INT DEFAULT NULL, prix INT NOT NULL, depart VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, arrive VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, temps VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, categorie VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, pays VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX iddest (destination_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commentaire (id_coment INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, contenu TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dateNow DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX fk_Commentaire_post (post_id), PRIMARY KEY(id_coment)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE destination (iddest INT AUTO_INCREMENT NOT NULL, countries VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(iddest)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE evenements (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateDebut DATE DEFAULT NULL, description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, lieu VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, tarif NUMERIC(10, 2) DEFAULT NULL, places_disponibles INT DEFAULT NULL, INDEX fk_categorie (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participants (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, telephone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, sujet TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, transport_id INT NOT NULL, client_id INT NOT NULL, debutReservartion DATE DEFAULT NULL, INDEX transport_id (transport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, evenement_id INT DEFAULT NULL, places_reservees INT DEFAULT NULL, participant_id INT DEFAULT NULL, dateheure_reservation DATETIME DEFAULT NULL, validate TINYINT(1) DEFAULT 0, INDEX fk_evenement_reservation (evenement_id), INDEX fk_participant_reservation (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, cap INT NOT NULL, type VARCHAR(33) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dd VARCHAR(33) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, da VARCHAR(33) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (idU INT AUTO_INCREMENT NOT NULL, Nom VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Prenom VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, tel INT NOT NULL, mdp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, gender VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, Role VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, Age DATE DEFAULT NULL, PRIMARY KEY(idU)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE circuit ADD CONSTRAINT circuit_ibfk_1 FOREIGN KEY (destination_id) REFERENCES destination (iddest)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT fk_Commentaire_post FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT fk_categorie FOREIGN KEY (categorie_id) REFERENCES categories (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT fk_evenement_reservation FOREIGN KEY (evenement_id) REFERENCES evenements (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE reclamation CHANGE intitule intitule VARCHAR(50) NOT NULL, CHANGE emailu emailU VARCHAR(255) NOT NULL');
        $this->addSql('CREATE INDEX idU ON reclamation (idU)');
        $this->addSql('CREATE INDEX emailU ON reclamation (emailU)');
        $this->addSql('ALTER TABLE reponsereclamation DROP FOREIGN KEY FK_B052BA70454DD7AB');
        $this->addSql('ALTER TABLE reponsereclamation CHANGE prenom Prenom VARCHAR(20) NOT NULL, CHANGE idRec idRec INT NOT NULL');
        $this->addSql('CREATE INDEX Prenom ON reponsereclamation (Prenom)');
        $this->addSql('CREATE INDEX idU ON reponsereclamation (idU)');
        $this->addSql('CREATE INDEX textRec ON reponsereclamation (intitule)');
        $this->addSql('DROP INDEX idx_b052ba70454dd7ab ON reponsereclamation');
        $this->addSql('CREATE INDEX idRec ON reponsereclamation (idRec)');
        $this->addSql('ALTER TABLE reponsereclamation ADD CONSTRAINT FK_B052BA70454DD7AB FOREIGN KEY (idRec) REFERENCES reclamation (idrec)');
    }
}
