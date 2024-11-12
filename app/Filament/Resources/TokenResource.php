<?php

namespace App\Filament\Resources;

use App\Filament\Actions\RevokeTableAction;
use App\Filament\Resources\TokenResource\Pages;
use Laravel\Passport\Token;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TokenResource extends Resource
{
    protected static ?string $model = Token::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?int $navigationSort = 20;

    protected static ?string $navigationGroup = 'Passport';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.email'),
                Tables\Columns\TextColumn::make('client.name'),
                Tables\Columns\TextColumn::make('scopes')
                    ->badge(),
                Tables\Columns\IconColumn::make('revoked')
                    ->label('Revoked')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('client_id')
                    ->label('Client')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('revoked')
                    ->label('Revoked'),
            ])
            ->actions([
                RevokeTableAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTokens::route('/'),
        ];
    }
}
