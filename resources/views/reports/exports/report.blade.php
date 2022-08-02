@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
@endphp

<table>
	<tr><td style="{{ $bold }} {{ $center }}" colspan="{{ sizeof($headers) }}">{{ $title }}</td></tr>
	
	<tr>
		@foreach($headers as $header)
			<td style="{{ $bold }} {{ $center }}">{{ $header }}</td>
		@endforeach
	</tr>
	@foreach($datas as $record)
		<tr>
			@foreach($headers as $header)
				<td style="{{ $center }}">{{ $record[$header] }}</td>
			@endforeach
		</tr>
	@endforeach
</table>