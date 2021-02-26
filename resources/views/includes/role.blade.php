@if($role === 'author')
<h4>Autor*in</h4>
@elseif($role === 'editor')
<h4>Herausgeber*in</h4>
@elseif($role === 'contributor')
<h4>Mitwirkende*r</h4>
@endif
