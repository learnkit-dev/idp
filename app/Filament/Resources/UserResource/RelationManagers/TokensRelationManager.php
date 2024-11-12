<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Tables\Actions\DeleteAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Laravel\Passport\Token;

class TokensRelationManager extends RelationManager
{
    protected static string $relationship = 'tokens';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('created_at')
            ->columns([
                Tables\Columns\TextColumn::make('created_at'),
                Tables\Columns\TextColumn::make('client.name'),
                Tables\Columns\TextColumn::make('scopes')
                    ->badge(),
                Tables\Columns\IconColumn::make('revoked')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('revoke')
                    ->label('Revoke')
                    ->requiresConfirmation()
                    ->visible(fn (Token $record): bool => $record->revoked === false)
                    ->icon('heroicon-m-hand-raised')
                    ->action(function (Token $record): void {
                        $record->update([
                            'revoked' => true,
                        ]);
                    }),
                DeleteAction::make()
                    ->visible(fn (Token $record): bool => $record->revoked === true),
            ]);
    }
}
