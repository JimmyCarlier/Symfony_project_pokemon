<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240816090442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, forum_id INT NOT NULL, user_comm VARCHAR(255) NOT NULL, INDEX IDX_67F068BC29CCBAD0 (forum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, titre_forum VARCHAR(255) NOT NULL, INDEX IDX_852BBECDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, nom_location VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon (id INT AUTO_INCREMENT NOT NULL, pokemon_element1_id INT DEFAULT NULL, pokemon_element2_id INT DEFAULT NULL, pokemon_rarity_id INT DEFAULT NULL, user_id INT DEFAULT NULL, nom_pokemon VARCHAR(255) NOT NULL, hp INT NOT NULL, atk INT NOT NULL, def INT NOT NULL, INDEX IDX_62DC90F369716FC3 (pokemon_element1_id), INDEX IDX_62DC90F37BC4C02D (pokemon_element2_id), INDEX IDX_62DC90F3C29D9F55 (pokemon_rarity_id), INDEX IDX_62DC90F3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon_location (pokemon_id INT NOT NULL, location_id INT NOT NULL, INDEX IDX_D9FA40652FE71C3E (pokemon_id), INDEX IDX_D9FA406564D218E (location_id), PRIMARY KEY(pokemon_id, location_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon_element (id INT AUTO_INCREMENT NOT NULL, nom_element VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rarity (id INT AUTO_INCREMENT NOT NULL, rarity_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC29CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F369716FC3 FOREIGN KEY (pokemon_element1_id) REFERENCES pokemon_element (id)');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F37BC4C02D FOREIGN KEY (pokemon_element2_id) REFERENCES pokemon_element (id)');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F3C29D9F55 FOREIGN KEY (pokemon_rarity_id) REFERENCES rarity (id)');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pokemon_location ADD CONSTRAINT FK_D9FA40652FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_location ADD CONSTRAINT FK_D9FA406564D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC29CCBAD0');
        $this->addSql('ALTER TABLE forum DROP FOREIGN KEY FK_852BBECDA76ED395');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F369716FC3');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F37BC4C02D');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F3C29D9F55');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F3A76ED395');
        $this->addSql('ALTER TABLE pokemon_location DROP FOREIGN KEY FK_D9FA40652FE71C3E');
        $this->addSql('ALTER TABLE pokemon_location DROP FOREIGN KEY FK_D9FA406564D218E');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE pokemon');
        $this->addSql('DROP TABLE pokemon_location');
        $this->addSql('DROP TABLE pokemon_element');
        $this->addSql('DROP TABLE rarity');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
