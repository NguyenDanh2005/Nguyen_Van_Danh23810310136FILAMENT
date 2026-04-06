<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $slug = 'sv23810310136/products';

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-shopping-bag';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    Select::make('category_id')
                        ->label('Danh mục')
                        ->relationship('category', 'name')
                        ->required()
                        ->searchable()
                        ->preload(),
                    TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),
                    TextInput::make('price')
                        ->label('Giá (VNĐ)')
                        ->required()
                        ->numeric()
                        ->minValue(0)
                        ->prefix('₫')
                        ->inputMode('decimal'),
                    TextInput::make('stock_quantity')
                        ->label('Tồn kho')
                        ->required()
                        ->integer()
                        ->minValue(0),
                    ToggleButtons::make('status')
                        ->options([
                            'draft' => 'Nháp',
                            'published' => 'Xuất bản',
                            'out_of_stock' => 'Hết hàng',
                        ])
                        ->colors([
                            'draft' => 'gray',
                            'published' => 'success',
                            'out_of_stock' => 'danger',
                        ])
                        ->inline()
                        ->default('draft'),
                    FileUpload::make('image_path')
                        ->label('Ảnh đại diện')
                        ->image()
                        ->directory('products')
                        ->visibility('public')
                        ->maxSize(2048)
                        ->columnSpanFull(),
                    RichEditor::make('description')
                        ->label('Mô tả sản phẩm')
                        ->toolbarButtons(['bold', 'italic', 'underline', 'bulletList', 'orderedList', 'link'])
                        ->columnSpanFull(),
                    TextInput::make('warranty_months')
                        ->label('Bảo hành (tháng)')
                        ->integer()
                        ->minValue(0)
                        ->default(12)
                        ->helperText('Số tháng bảo hành của sản phẩm'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')->label('Ảnh')->circular(),
                Tables\Columns\TextColumn::make('name')->label('Tên sản phẩm')->searchable(),
                Tables\Columns\TextColumn::make('category.name')->label('Danh mục'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Giá')
                    ->money('VND', true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_quantity')->label('Tồn kho'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'out_of_stock' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('warranty_months')->label('Bảo hành (tháng)'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Danh mục')
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Nháp',
                        'published' => 'Xuất bản',
                        'out_of_stock' => 'Hết hàng',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}