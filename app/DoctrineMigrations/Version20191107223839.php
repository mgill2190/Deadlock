<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191107223839 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE shipment (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE container (id INT AUTO_INCREMENT NOT NULL, container_no VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, shipment_id INT NOT NULL, container_id INT DEFAULT NULL, type_id VARCHAR(3) DEFAULT NULL, transport_date DATETIME DEFAULT NULL, INDEX IDX_66AB212E7BE036FC (shipment_id), INDEX IDX_66AB212EBC21F742 (container_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transport ADD CONSTRAINT FK_66AB212E7BE036FC FOREIGN KEY (shipment_id) REFERENCES shipment (id)');
        $this->addSql('ALTER TABLE transport ADD CONSTRAINT FK_66AB212EBC21F742 FOREIGN KEY (container_id) REFERENCES container (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transport DROP FOREIGN KEY FK_66AB212E7BE036FC');
        $this->addSql('ALTER TABLE transport DROP FOREIGN KEY FK_66AB212EBC21F742');
        $this->addSql('DROP TABLE shipment');
        $this->addSql('DROP TABLE container');
        $this->addSql('DROP TABLE transport');
    }
}
