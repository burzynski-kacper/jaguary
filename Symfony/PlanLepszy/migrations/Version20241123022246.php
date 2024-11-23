<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241123022246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE department (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, courses CLOB DEFAULT NULL)');
        $this->addSql('CREATE TABLE lecturer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, info CLOB DEFAULT NULL)');
        $this->addSql('CREATE TABLE lecturer_department (lecturer_id INTEGER NOT NULL, department_id INTEGER NOT NULL, PRIMARY KEY(lecturer_id, department_id), CONSTRAINT FK_59F2DC60BA2D8762 FOREIGN KEY (lecturer_id) REFERENCES lecturer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_59F2DC60AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_59F2DC60BA2D8762 ON lecturer_department (lecturer_id)');
        $this->addSql('CREATE INDEX IDX_59F2DC60AE80F5DF ON lecturer_department (department_id)');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, department_id INTEGER DEFAULT NULL, number VARCHAR(100) DEFAULT NULL, CONSTRAINT FK_729F519BAE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_729F519BAE80F5DF ON room (department_id)');
        $this->addSql('CREATE TABLE subject (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) DEFAULT NULL, course CLOB DEFAULT NULL, semester VARCHAR(50) DEFAULT NULL, type_of_course VARCHAR(50) DEFAULT NULL, nr_of_hours INTEGER DEFAULT NULL, ects INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE subject_lecturer (subject_id INTEGER NOT NULL, lecturer_id INTEGER NOT NULL, PRIMARY KEY(subject_id, lecturer_id), CONSTRAINT FK_2CB2112E23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2CB2112EBA2D8762 FOREIGN KEY (lecturer_id) REFERENCES lecturer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_2CB2112E23EDC87 ON subject_lecturer (subject_id)');
        $this->addSql('CREATE INDEX IDX_2CB2112EBA2D8762 ON subject_lecturer (lecturer_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__student AS SELECT id, rodzaj_studiów FROM student');
        $this->addSql('DROP TABLE student');
        $this->addSql('CREATE TABLE student (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_of_course VARCHAR(50) DEFAULT NULL, info CLOB DEFAULT NULL, course CLOB DEFAULT NULL, semester VARCHAR(50) DEFAULT NULL)');
        $this->addSql('INSERT INTO student (id, type_of_course) SELECT id, rodzaj_studiów FROM __temp__student');
        $this->addSql('DROP TABLE __temp__student');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE lecturer');
        $this->addSql('DROP TABLE lecturer_department');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE subject_lecturer');
        $this->addSql('CREATE TEMPORARY TABLE __temp__student AS SELECT id FROM student');
        $this->addSql('DROP TABLE student');
        $this->addSql('CREATE TABLE student (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, identyfikator INTEGER NOT NULL, imię VARCHAR(50) NOT NULL, nazwisko VARCHAR(50) NOT NULL, kierunek_studiów VARCHAR(100) NOT NULL, semestr INTEGER NOT NULL, rodzaj_studiów VARCHAR(50) DEFAULT NULL)');
        $this->addSql('INSERT INTO student (id) SELECT id FROM __temp__student');
        $this->addSql('DROP TABLE __temp__student');
    }
}
