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
			<td style="{{ $center }}">{{ $record["Category"] }}</td>
			<td style="{{ $center }}">{{ $record["Item"] }}</td>
			<td style="{{ $center }}">{{ $record["Type"] }}</td>
			<td style="{{ $center }}">{{ $record["Receiving"] }}</td>
			<td style="{{ $center }}">{{ $record["Issuance"] }}</td>
			<td style="{{ $center }}">{{ $record["Running Balance"] }}</td>
			<td style="{{ $center }}">{{ $record["Date"] }}</td>
		</tr>
	@endforeach
</table>