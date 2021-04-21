<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210419000000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS department (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            name VARCHAR(255) NOT NULL,
            seniority_increment_bonus INTEGER DEFAULT NULL,
            percent_bonus DOUBLE PRECISION DEFAULT NULL,
            CHECK(seniority_increment_bonus IS NULL OR percent_bonus IS NULL)
        )');
        $this->addSql('CREATE TABLE IF NOT EXISTS employee (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            department_id INTEGER DEFAULT NULL,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            base_salary INTEGER NOT NULL,
            employed_since DATE NOT NULL
        )');
        $this->addSql('CREATE INDEX IDX_5D9F75A1AE80F5DF ON employee (department_id)');

        $this->addSql("INSERT INTO department VALUES (1, 'HR', 100e2, NULL)");
        $this->addSql("INSERT INTO department VALUES (2, 'Customer Support', NULL, 10)");

        $this->addSql("INSERT INTO employee VALUES (1, 1, 'Adam', 'Kowalski', 1000e2, '2006-01-05')");
        $this->addSql("INSERT INTO employee VALUES (2, 2, 'Anna', 'Nowak', 1100e2, '2016-02-07')");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE employee');
    }
}
