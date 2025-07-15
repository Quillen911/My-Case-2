<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa</title>
</head>
<body>
    <h1>Hoşgeldiniz</h1>
    <h2>Ürünler</h2>

    <table border="5" cellpadding="8" cellspacing="0" >
        <thead>
            <tr>
                <th>ID</th>
                <th>Ürün Adı</th>
                <th>Kategori ID</th>
                <th>Kategori Adı</th>
                <th>Yazar</th>
                <th>Fiyat</th>
                <th>Ürün Sayısı</th>
                <th>           </th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
                <tr>
                    <td>{{$p->id}} </td>
                    <td>{{$p->title}} </td>
                    <td>{{$p->category_id}}</td>
                    <td>{{ $p->category?->category_title }}</td>
                    <td>{{$p->author}} </td>
                    <td>{{$p->list_price}} </td>
                    <td>{{$p->stock_quantity}} </td>
                    <td>
                        <a href="{{ route('sepet', $p->id) }}">Sepete Ekle</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        {{ $products->links() }}
    </table>

    <a href="/sepet">Sepete Git</a>

</body>
</html>