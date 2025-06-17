<h2>Product List</h2>
<ul>
{{{ foreach($products as $product): }}}
    <li>{{ $product['name'] }}</li>
{{{ endforeach; }}}
</ul>
