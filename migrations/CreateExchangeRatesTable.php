<?php

class CreateExchangeRatesTable
{
    public function up(): string
    {
        return "CREATE TABLE IF NOT EXISTS exchange_rates (
            id INT AUTO_INCREMENT PRIMARY KEY,
            currency_code VARCHAR(3),
            currency_name VARCHAR(50),
            exchange_rate DECIMAL(10, 2),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
    }

    public function down(): string
    {
        return "DROP TABLE IF EXISTS exchange_rates";
    }
}