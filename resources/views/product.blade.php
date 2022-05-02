<h1>{{$name}}</h1>
product.bplade.php dosyasındayız ve product ıd : {{$id}}, Type: {{$r_type}}


<div>
    @if( $id == 1)
        1 numaralı ürün gösterilmektedir.
    @elseif( $id == 2)
        2 numaralı ürün gösterilmektedir.
    @else
        diğer bir ürün gösterilmektedir.
    @endif
</div>


<div>
    @for($i=0; $i<10;$i++)
        Döngü Değeri : {{$i}}<br>
    @endfor
</div>

<div>
    @foreach($categories as $category)
        {{$category}}
    @endforeach
</div>
