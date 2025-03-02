<?php

namespace App\Core\Models;

class PasswordReset extends Model
{
    protected string $table = 'password_resets';

    public function createResetToken(string $email, string $token): bool
    {
        $this->execute("DELETE FROM password_resets WHERE email = ?", [$email]);
        return $this->execute("INSERT INTO password_resets (email, token) VALUES (?, ?)", [$email, $token]);
    }

    public function getByToken(string $token): ?array
    {
        $result = $this->query("SELECT * FROM password_resets WHERE token = ? LIMIT 1", [$token]);
        return $result ? $result[0] : null;
    }

    public function deleteByEmail(string $email): void
    {
        $this->execute("DELETE FROM password_resets WHERE email = ?", [$email]);
    }
}
