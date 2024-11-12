<?php

namespace App\Filament\Actions;

use Laravel\Passport\Token;
use Filament\Tables\Actions\Action;

class RevokeTableAction extends Action
{
    public function setUp(): void
    {
        $this->label('Revoke');

        $this->color('danger');

        $this->requiresConfirmation();

        $this->visible(fn (Token $record): bool => $record->revoked === false);

        $this->icon('heroicon-m-hand-raised');

        $this->action(function (Token $record): void {
            $record->update([
                'revoked' => true,
            ]);
        });
    }

    public static function make(?string $name = 'revoke'): static
    {
        return parent::make($name);
    }
}
