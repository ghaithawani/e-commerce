<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209233003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (idCommande INT AUTO_INCREMENT NOT NULL, dateCommande DATETIME DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, montantTotal NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(idCommande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (idlivraison INT AUTO_INCREMENT NOT NULL, id_vehicule INT DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, destinataire VARCHAR(255) DEFAULT NULL, date_livraison VARCHAR(255) NOT NULL, INDEX fk_idvehicule (id_vehicule), PRIMARY KEY(idlivraison)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at VARCHAR(255) NOT NULL, available_at VARCHAR(255) NOT NULL, delivered_at VARCHAR(255) NOT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produits (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, description VARCHAR(255) DEFAULT NULL, categorie VARCHAR(255) DEFAULT NULL, dateajout DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (idrec INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, descrirec VARCHAR(255) NOT NULL, categorierec VARCHAR(255) NOT NULL, statutrec VARCHAR(255) NOT NULL, archive TINYINT(1) DEFAULT NULL, PRIMARY KEY(idrec)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response (idrep INT AUTO_INCREMENT NOT NULL, idrec INT NOT NULL, daterep DATETIME NOT NULL, contenurep VARCHAR(255) NOT NULL, INDEX fk_idrec (idrec), PRIMARY KEY(idrep)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (transactionId INT AUTO_INCREMENT NOT NULL, sender VARCHAR(255) DEFAULT \'NULL\', receiver VARCHAR(255) DEFAULT \'NULL\', qrcode VARCHAR(255) DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, idCommande INT DEFAULT NULL, INDEX fk_idcommande (idCommande), PRIMARY KEY(transactionId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (idvehicule INT AUTO_INCREMENT NOT NULL, marque VARCHAR(255) DEFAULT NULL, modele VARCHAR(255) DEFAULT NULL, annee INT DEFAULT NULL, couleur VARCHAR(50) DEFAULT NULL, immatriculation VARCHAR(20) DEFAULT NULL, UNIQUE INDEX immatriculation (immatriculation), PRIMARY KEY(idvehicule)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente (id INT AUTO_INCREMENT NOT NULL, quantitevendu INT NOT NULL, datevente DATE NOT NULL, montanttotal DOUBLE PRECISION NOT NULL, idProduit INT NOT NULL, INDEX IDX_888A2A4C391C87D5 (idProduit), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F79F41388 FOREIGN KEY (id_vehicule) REFERENCES vehicule (idvehicule)');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFB7D00914B FOREIGN KEY (idrec) REFERENCES reclamation (idrec)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D13D498C26 FOREIGN KEY (idCommande) REFERENCES commande (idCommande)');
        $this->addSql('ALTER TABLE vente ADD CONSTRAINT FK_888A2A4C391C87D5 FOREIGN KEY (idProduit) REFERENCES produits (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F79F41388');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFB7D00914B');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D13D498C26');
        $this->addSql('ALTER TABLE vente DROP FOREIGN KEY FK_888A2A4C391C87D5');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP TABLE produits');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE response');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('DROP TABLE vente');
    }
}
