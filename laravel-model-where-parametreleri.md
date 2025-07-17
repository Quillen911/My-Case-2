# Laravel Model `where()` Fonksiyonu Parametreleri

Laravel'de Eloquent Model'in `where()` fonksiyonu, veritabanı sorgularında koşullu filtreleme yapmak için kullanılan en temel ve önemli metodlardan biridir. Bu fonksiyon farklı parametre kombinasyonlarını kabul eder ve esneklik sağlar.

## Temel Sözdizimi (Syntax)

```php
Model::where('kolon_adı', 'operatör', 'değer')
Model::where('kolon_adı', 'değer') // operatör varsayılan olarak '=' olur
```

## Parametre Türleri

### 1. Üç Parametreli Kullanım

En yaygın kullanım şekli:

```php
$users = User::where('age', '>', 18)->get();
$users = User::where('status', '=', 'active')->get();
$users = User::where('name', 'like', '%John%')->get();
```

**Parametreler:**
- **Birinci parametre**: Kolon adı (string)
- **İkinci parametre**: Operatör (string)
- **Üçüncü parametre**: Değer (mixed)

### 2. İki Parametreli Kullanım

Operatör belirtilmediğinde varsayılan olarak `=` kullanılır:

```php
$users = User::where('status', 'active')->get();
// Bu şuna eşittir: User::where('status', '=', 'active')->get();
```

**Parametreler:**
- **Birinci parametre**: Kolon adı (string)
- **İkinci parametre**: Değer (mixed)

### 3. Dizi (Array) Parametreli Kullanım

Birden fazla koşulu aynı anda belirtmek için:

```php
$users = User::where([
    ['status', '=', 'active'],
    ['age', '>', 18],
    ['city', 'like', '%istanbul%']
])->get();

// Kısa form (sadece eşitlik için)
$users = User::where([
    'status' => 'active',
    'role' => 'admin'
])->get();
```

### 4. Closure (Anonim Fonksiyon) Parametreli Kullanım

Karmaşık koşullar için:

```php
$users = User::where(function ($query) {
    $query->where('age', '>', 18)
          ->orWhere('status', 'premium');
})->get();
```

## Desteklenen Operatörler

Laravel `where()` fonksiyonu aşağıdaki operatörleri destekler:

| Operatör | Açıklama | Örnek |
|----------|----------|-------|
| `=` | Eşittir | `where('age', '=', 25)` |
| `!=` | Eşit değildir | `where('status', '!=', 'banned')` |
| `<>` | Eşit değildir (alternatif) | `where('age', '<>', 0)` |
| `>` | Büyüktür | `where('price', '>', 100)` |
| `>=` | Büyük eşittir | `where('age', '>=', 18)` |
| `<` | Küçüktür | `where('stock', '<', 10)` |
| `<=` | Küçük eşittir | `where('discount', '<=', 50)` |
| `LIKE` | Benzer (pattern matching) | `where('name', 'like', '%john%')` |
| `NOT LIKE` | Benzer değil | `where('email', 'not like', '%@spam.com')` |
| `BETWEEN` | Arasında | `whereBetween('age', [18, 65])` |
| `NOT BETWEEN` | Arasında değil | `whereNotBetween('price', [100, 200])` |
| `IN` | İçinde | `whereIn('status', ['active', 'pending'])` |
| `NOT IN` | İçinde değil | `whereNotIn('role', ['banned', 'suspended'])` |
| `IS NULL` | Boş | `whereNull('deleted_at')` |
| `IS NOT NULL` | Boş değil | `whereNotNull('email_verified_at')` |

## Parametre Değer Türleri

`where()` fonksiyonu farklı değer türlerini kabul eder:

### String Değerler
```php
User::where('name', 'Ahmet')->get();
User::where('email', 'like', '%@gmail.com')->get();
```

### Sayısal Değerler
```php
User::where('age', 25)->get();
User::where('price', '>', 99.99)->get();
```

### Boolean Değerler
```php
User::where('is_active', true)->get();
User::where('email_verified', false)->get();
```

### Null Değerler
```php
User::where('deleted_at', null)->get();
// veya daha iyi:
User::whereNull('deleted_at')->get();
```

### Tarih Değerleri
```php
User::where('created_at', '>', '2023-01-01')->get();
User::where('birthday', Carbon::today())->get();
```

## Özel where() Metodları

Laravel birçok özelleştirilmiş `where` metodu sağlar:

### Tarih Bazlı
```php
User::whereDate('created_at', '2023-12-25')->get();
User::whereMonth('created_at', 12)->get();
User::whereDay('created_at', 25)->get();
User::whereYear('created_at', 2023)->get();
User::whereTime('created_at', '14:30:00')->get();
```

### JSON Kolonlar
```php
User::where('settings->language', 'tr')->get();
User::where('meta->profile->age', '>', 18)->get();
```

### Dinamik where Metodları
```php
User::whereEmail('[email protected]')->get();
User::whereName('Ahmet')->get();
User::whereAgeAndStatus(25, 'active')->get();
User::whereNameOrEmail('Ahmet', '[email protected]')->get();
```

## Zincirleme (Chaining) Kullanım

```php
$users = User::where('status', 'active')
             ->where('age', '>', 18)
             ->where('city', 'İstanbul')
             ->orderBy('created_at', 'desc')
             ->limit(10)
             ->get();
```

## orWhere() ile Kullanım

```php
$users = User::where('status', 'active')
             ->orWhere('role', 'premium')
             ->get();

// Karmaşık OR koşulları için
$users = User::where('status', 'active')
             ->orWhere(function($query) {
                 $query->where('role', 'premium')
                       ->where('subscription_expires', '>', now());
             })->get();
```

## Parametre Güvenliği

Laravel'in `where()` fonksiyonu **PDO parameter binding** kullanarak SQL injection saldırılarına karşı otomatik koruma sağlar:

```php
// GÜVENLİ - Laravel otomatik olarak parametreleri escape eder
$userId = $_GET['user_id']; // Kullanıcıdan gelen veri
User::where('id', $userId)->first();

// GÜVENSİZ - Raw SQL kullanımı
User::whereRaw("id = " . $userId)->first(); // Kullanmayın!

// GÜVENLİ Raw SQL kullanımı
User::whereRaw('id = ?', [$userId])->first();
```

## Performans İpuçları

1. **Index kullanımı**: `where()` koşullarında kullanılan kolonlarda index olduğundan emin olun
2. **Select optimizasyonu**: Sadece ihtiyacınız olan kolonları seçin
3. **Eager loading**: İlişkili verileri önceden yükleyin

```php
// İyi performans
User::select(['id', 'name', 'email'])
    ->where('status', 'active')
    ->with('profile')
    ->get();
```

## Örnekler

### Basit Filtreleme
```php
// Aktif kullanıcıları getir
$activeUsers = User::where('status', 'active')->get();

// 18 yaşından büyük kullanıcılar
$adults = User::where('age', '>', 18)->get();

// Gmail kullanıcıları
$gmailUsers = User::where('email', 'like', '%@gmail.com')->get();
```

### Karmaşık Koşullar
```php
$users = User::where('status', 'active')
             ->where(function($query) {
                 $query->where('role', 'admin')
                       ->orWhere('role', 'moderator');
             })
             ->where('last_login', '>', now()->subDays(30))
             ->get();
```

### Tarih Bazlı Sorgular
```php
// Bu ay kayıt olan kullanıcılar
$thisMonthUsers = User::whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year)
                      ->get();

// Son hafta aktif olan kullanıcılar
$recentActive = User::where('last_activity', '>', now()->subWeek())->get();
```

Laravel'in `where()` fonksiyonu bu esnekliği sayesinde hemen hemen her türlü veritabanı sorgusunu güvenli ve okunabilir bir şekilde yazmanıza olanak tanır.