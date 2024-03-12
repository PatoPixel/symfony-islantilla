<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240308200806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente (dni VARCHAR(9) NOT NULL, nombre VARCHAR(40) NOT NULL, edad SMALLINT NOT NULL, PRIMARY KEY(dni)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('INSERT INTO cliente (dni, nombre, edad) VALUES ("12345678A", "Juan Pérez", 35)');
        $this->addSql('INSERT INTO cliente (dni, nombre, edad) VALUES ("87654321B", "Ana López", 28)');
        $this->addSql('INSERT INTO cliente (dni, nombre, edad) VALUES ("09876543C", "Pedro Garcia", 42)');
        $this->addSql('INSERT INTO cliente (dni, nombre, edad) VALUES ("76543210A", "Maria Fernandez", 25)');
        $this->addSql('INSERT INTO cliente (dni, nombre, edad) VALUES ("98765432C", "Chiquito de la Calzada", 18)');
        $this->addSql('INSERT INTO cliente (dni, nombre, edad) VALUES ("01234567B", "Penelope Cruz", 84)');        

        $this->addSql('CREATE TABLE habitacion (numero SMALLINT NOT NULL, precio INT NOT NULL, camas SMALLINT NOT NULL, bano TINYINT(1) NOT NULL, PRIMARY KEY(numero)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('INSERT INTO habitacion (numero, precio, camas, bano) VALUES (101, 100, 2, 1)');
        $this->addSql('INSERT INTO habitacion (numero, precio, camas, bano) VALUES (832, 150, 1, 0)');
        $this->addSql('INSERT INTO habitacion (numero, precio, camas, bano) VALUES (294, 120, 3, 1)');
        $this->addSql('INSERT INTO habitacion (numero, precio, camas, bano) VALUES (131, 80, 1, 0)');        
        $this->addSql('INSERT INTO habitacion (numero, precio, camas, bano) VALUES (321, 150, 2, 1)');
        $this->addSql('INSERT INTO habitacion (numero, precio, camas, bano) VALUES (102, 90, 1, 0)');        
        
        $this->addSql('CREATE TABLE reserva (id INT AUTO_INCREMENT NOT NULL, dni_cliente VARCHAR(9) NOT NULL, numero_habitacion SMALLINT NOT NULL, fecha_reserva DATE NOT NULL, fecha_llegada DATE NOT NULL, fecha_salida DATE NOT NULL, INDEX IDX_188D2E3B5112F25B (dni_cliente), INDEX IDX_188D2E3B94A40819 (numero_habitacion), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('INSERT INTO reserva (dni_cliente, numero_habitacion, fecha_reserva, fecha_llegada, fecha_salida) VALUES ("12345678A", 101, "2023-07-12", "2023-08-15", "2023-08-20")');
        $this->addSql('INSERT INTO reserva (dni_cliente, numero_habitacion, fecha_reserva, fecha_llegada, fecha_salida) VALUES ("87654321B", 832, "2024-03-08", "2024-03-12", "2024-03-14")');
        $this->addSql('INSERT INTO reserva (dni_cliente, numero_habitacion, fecha_reserva, fecha_llegada, fecha_salida) VALUES ("09876543C", 321, "2022-05-25", "2022-09-13", "2022-09-18")');
        $this->addSql('INSERT INTO reserva (dni_cliente, numero_habitacion, fecha_reserva, fecha_llegada, fecha_salida) VALUES ("09876543C", 321, "2022-12-25", "2023-01-13", "2023-01-20")');
        $this->addSql('INSERT INTO reserva (dni_cliente, numero_habitacion, fecha_reserva, fecha_llegada, fecha_salida) VALUES ("76543210A", 294, "2024-03-08", "2024-05-26", "2024-06-01")');        
        $this->addSql('INSERT INTO reserva (dni_cliente, numero_habitacion, fecha_reserva, fecha_llegada, fecha_salida) VALUES ("98765432C", 294, "2021-12-10", "2022-02-14", "2022-02-15")');
        $this->addSql('INSERT INTO reserva (dni_cliente, numero_habitacion, fecha_reserva, fecha_llegada, fecha_salida) VALUES ("98765432C", 294, "2023-05-01", "2023-07-01", "2023-07-15")');
        $this->addSql('INSERT INTO reserva (dni_cliente, numero_habitacion, fecha_reserva, fecha_llegada, fecha_salida) VALUES ("98765432C", 294, "2024-04-12", "2024-06-17", "2024-06-20")');
        $this->addSql('INSERT INTO reserva (dni_cliente, numero_habitacion, fecha_reserva, fecha_llegada, fecha_salida) VALUES ("98765432C", 294, "2021-04-10", "2021-07-14", "2021-07-20")');
        $this->addSql('INSERT INTO reserva (dni_cliente, numero_habitacion, fecha_reserva, fecha_llegada, fecha_salida) VALUES ("01234567B", 102, "2019-03-11", "2019-03-13", "2019-03-17")');        

        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B5112F25B FOREIGN KEY (dni_cliente) REFERENCES cliente (dni) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B94A40819 FOREIGN KEY (numero_habitacion) REFERENCES habitacion (numero) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3B5112F25B');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3B94A40819');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE habitacion');
        $this->addSql('DROP TABLE reserva');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
