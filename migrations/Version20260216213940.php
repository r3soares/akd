<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260216213940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AEDAD51C5E237E06 ON exercise (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC77D1D08F2890A2 ON exercise_execution (short)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_649FFB725E237E06 ON workout (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_AEDAD51C5E237E06');
        $this->addSql('DROP INDEX UNIQ_AC77D1D08F2890A2');
        $this->addSql('DROP INDEX UNIQ_649FFB725E237E06');
    }
}
