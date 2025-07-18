<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siparişini Tamamla</title>
</head>
<body>
    <h1>Sipariş Özeti</h1>
    @if(isset($success))
        <p>{{$success}}</p>
    @endif
    @if(isset($error))
        <p>{{$error}}</p>
    @endif
    
    <table border="5" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Ürün Adı</th>
                <th>Kategori Adı</th>
                <th>Yazar</th>
                <th>Ürün Sayısı</th>
                <th>Fiyat</th>
                <th>Toplam Fiyat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
                <tr>
                    <td>{{$p->product->title}}</td>
                    <td>{{$p->product->category?->category_title}}</td>
                    <td>{{$p->product->author}}</td>
                    <td>{{$p->quantity}}</td>
                    <td>{{$p->product->list_price}}</td>
                    <td>{{$p->product->list_price * $p->quantity}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    @if($products->sum('product.list_price') < 50)
        <label>Kargo Ücreti</label> <label>10 TL </label> <br>
        <label>Toplam Fiyat</label> 
        <label>{{$products->sum(function($item) {
            return $item->quantity * $item->product->list_price;
        }) + 10}} TL</label>
    @elseif($products->sum('product.list_price') > 50)    
        <label>Kargo Ücreti</label> <label>50 TL üzeri siparişlerde kargo ücretsizdir!</label> <br>
        <label>Toplam Fiyat</label> 
        <label>{{$products->sum(function($item) {
            return $item->quantity * $item->product->list_price;
        })}} TL</label>
    @endif
    
    <br>

    <form action="{{route('ordergo')}}" method="POST">
        @csrf
        <button type="submit">Siparişi Tamamla</button>
    </form>
    
    <a href="{{route('bag')}}">Sepetine geri dön</a>
</body>
</html>