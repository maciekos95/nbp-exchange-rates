<?php

class CreateConversionResultsTable
{
    public function up(): string
    {
        return "CREATE TABLE IF NOT EXISTS conversion_results (
            id INT AUTO_INCREMENT PRIMARY KEY,
            source_currency VARCHAR(3),
            target_currency VARCHAR(3),
            amount DECIMAL(10, 2),
            converted_amount DECIMAL(10, 2),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
    }

    public function down(): string
    {
        return "DROP TABLE IF EXISTS conversion_results";
    }
}
