<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240603081913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article CHANGE nom nom VARCHAR(100) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE prix prix NUMERIC(10, 2) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE rating rating INT NOT NULL, CHANGE categorie_id categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66BCF5E72D ON article (categorie_id)');
        $this->addSql('ALTER TABLE commande CHANGE date date DATETIME NOT NULL, CHANGE montant montant NUMERIC(10, 2) NOT NULL, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DA76ED395 ON commande (user_id)');
        $this->addSql('ALTER TABLE ligne_commande CHANGE quantite quantite INT NOT NULL, CHANGE commande_id commande_id INT NOT NULL, CHANGE article_id article_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_3170B74B82EA2E54 ON ligne_commande (commande_id)');
        $this->addSql('CREATE INDEX IDX_3170B74B7294869C ON ligne_commande (article_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE nom nom VARCHAR(100) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE adresse adresse VARCHAR(100) NOT NULL, CHANGE code_postal code_postal VARCHAR(10) NOT NULL, CHANGE ville ville VARCHAR(10) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66BCF5E72D');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON user');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT DEFAULT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE nom nom VARCHAR(100) DEFAULT NULL, CHANGE prenom prenom VARCHAR(100) DEFAULT NULL, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL, CHANGE code_postal code_postal VARCHAR(10) DEFAULT NULL, CHANGE ville ville VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('DROP INDEX IDX_6EEAA67DA76ED395 ON commande');
        $this->addSql('ALTER TABLE commande CHANGE user_id user_id INT DEFAULT NULL, CHANGE date date DATETIME DEFAULT NULL, CHANGE montant montant NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B82EA2E54');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B7294869C');
        $this->addSql('DROP INDEX IDX_3170B74B82EA2E54 ON ligne_commande');
        $this->addSql('DROP INDEX IDX_3170B74B7294869C ON ligne_commande');
        $this->addSql('ALTER TABLE ligne_commande CHANGE commande_id commande_id INT DEFAULT NULL, CHANGE article_id article_id INT DEFAULT NULL, CHANGE quantite quantite INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_23A0E66BCF5E72D ON article');
        $this->addSql('ALTER TABLE article CHANGE categorie_id categorie_id INT DEFAULT NULL, CHANGE nom nom VARCHAR(100) DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE prix prix NUMERIC(10, 2) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE rating rating INT DEFAULT NULL');
    }
}
