@php
  use Illuminate\Support\Str;
@endphp
<table border="1" cellspacing="0" cellpadding="4">
  <colgroup>
    <col style="width:40px">
    <col style="width:150px">
    <col style="width:120px">
    <col style="width:150px">
    <col style="width:130px">
    <col style="width:100px">
    <col style="width:130px">
    <col style="width:130px">
    <col style="width:110px">
    <col style="width:150px">
    <col style="width:250px">
    <col style="width:150px">
    <col style="width:250px">
    <col style="width:180px">
    <col style="width:120px">
    <col style="width:140px">
  </colgroup>

  <thead>
    <tr>
      <th colspan="16"
        style="
          font-weight:bold;
          font-size:13px;
          text-align:left;
          vertical-align:middle;
          height:30px;
        ">
        {{ $monthNow }}
      </th>
    </tr>

    <tr>
      <th rowspan="2" bgcolor="#0c1555"
        style="color:white;text-align:center;vertical-align:middle;font-size:10px;font-weight:bold;border:1px solid #ffffff;">
        No</th>
      <th rowspan="2" bgcolor="#0c1555"
        style="color:white;text-align:center;vertical-align:middle;font-size:10px;font-weight:bold;border:1px solid #ffffff;">
        Supplier</th>
      <th rowspan="2" bgcolor="#0c1555"
        style="color:white;text-align:center;vertical-align:middle;font-size:10px;font-weight:bold;border:1px solid #ffffff;">
        Jenis Item</th>
      <th rowspan="2" bgcolor="#0c1555"
        style="color:white;text-align:center;vertical-align:middle;font-size:10px;font-weight:bold;border:1px solid #ffffff;">
        No Approval Design</th>
      <th rowspan="2" bgcolor="#0c1555"
        style="color:white;text-align:center;vertical-align:middle;font-size:10px;font-weight:bold;border:1px solid #ffffff;">
        Tgl Email Masuk</th>
      <th rowspan="2" bgcolor="#0c1555"
        style="color:white;text-align:center;vertical-align:middle;font-size:10px;font-weight:bold;border:1px solid #ffffff;">
        Status</th>
      <th rowspan="2" bgcolor="#0c1555"
        style="color:white;text-align:center;vertical-align:middle;font-size:10px;font-weight:bold;border:1px solid #ffffff;">
        Mulai</th>
      <th rowspan="2" bgcolor="#0c1555"
        style="color:white;text-align:center;vertical-align:middle;font-size:10px;font-weight:bold;border:1px solid #ffffff;">
        Selesai</th>
      <th rowspan="2" bgcolor="#0c1555"
        style="color:white;text-align:center;vertical-align:middle;font-size:10px;font-weight:bold;border:1px solid #ffffff;">
        Durasi (jam.menit)</th>

      <th colspan="2" bgcolor="#0c1555"
        style="color:white;text-align:center;font-size:10px;font-weight:bold;border:1px solid #ffffff;">
        Approval Teks</th>
      <th colspan="2" bgcolor="#0c1555"
        style="color:white;text-align:center;font-size:10px;font-weight:bold;border:1px solid #ffffff;">
        Approval Warna</th>

      <th rowspan="2" bgcolor="#0c1555"
        style="color:white;text-align:center;vertical-align:middle;font-size:10px;font-weight:bold;border:1px solid #ffffff;">
        Remark</th>
      <th rowspan="2" bgcolor="#0c1555"
        style="color:white;text-align:center;vertical-align:middle;font-size:10px;font-weight:bold;border:1px solid #ffffff;">
        Creator</th>
      <th rowspan="2" bgcolor="#0c1555"
        style="color:white;text-align:center;vertical-align:middle;font-size:10px;font-weight:bold;border:1px solid #ffffff;">
        Tgl Dibuat</th>
    </tr>

    <tr>
      <th bgcolor="#0c1555"
        style="color:white;text-align:center;font-size:10px;font-weight:bold;border:1px solid #ffffff;">Tanggal</th>
      <th bgcolor="#0c1555"
        style="color:white;text-align:center;font-size:10px;font-weight:bold;border:1px solid #ffffff;">Ket</th>
      <th bgcolor="#0c1555"
        style="color:white;text-align:center;font-size:10px;font-weight:bold;border:1px solid #ffffff;">Tanggal</th>
      <th bgcolor="#0c1555"
        style="color:white;text-align:center;font-size:10px;font-weight:bold;border:1px solid #ffffff;">Ket</th>
    </tr>
  </thead>

  <tbody>
    @foreach ($items as $item)
      <tr>
        <td style="border:1px solid #000000; vertical-align:middle;" align="center">{{ $loop->iteration }}</td>
        <td style="border:1px solid #000000; vertical-align:middle;">{{ $item->supplier ?? '-' }}</td>
        <td style="border:1px solid #000000; vertical-align:middle;">{{ $item->item ?? '-' }}</td>
        <td style="border:1px solid #000000; vertical-align:middle;">{{ $item->no_approval ?? '-' }}</td>
        <td style="border:1px solid #000000; vertical-align:middle;" align="center">
          {{ $item->email_received_at ? \Carbon\Carbon::parse($item->email_received_at)->format('Y-m-d H:i:s') : '-' }}
        </td>
        <td style="border:1px solid #000000; vertical-align:middle;" align="center">
          @if ($item->start_time == null && $item->end_time == null)
            Not Started
          @elseif ($item->start_time != null && $item->end_time == null)
            In Progress
          @else
            Finished
          @endif
        </td>
        <td style="border:1px solid #000000; vertical-align:middle;" align="center">
          {{ $item->start_time ? \Carbon\Carbon::parse($item->start_time)->format('Y-m-d H:i:s') : '-' }}</td>
        <td style="border:1px solid #000000; vertical-align:middle;" align="center">
          {{ $item->end_time ? \Carbon\Carbon::parse($item->end_time)->format('Y-m-d H:i:s') : '-' }}
        </td>
        <td style="border:1px solid #000000; vertical-align:middle;" align="center">{{ $item->duration ?? '-' }}</td>

        <td style="border:1px solid #000000; vertical-align:middle;" align="center">
          {{ $item->text_created_at ? \Carbon\Carbon::parse($item->text_created_at)->format('Y-m-d H:i:s') : '-' }}
        </td>
        <td style="border:1px solid #000000; vertical-align:middle;" align="left">
          {!! $item->text_review ? '• ' . str_replace('||', '<br>• ', $item->text_review) : '-' !!}
        </td>

        <td style="border:1px solid #000000; vertical-align:middle;" align="center">
          {{ $item->color_created_at ? \Carbon\Carbon::parse($item->color_created_at)->format('Y-m-d H:i:s') : '-' }}
        </td>
        <td style="border:1px solid #000000; vertical-align:middle;" align="left">
          {!! $item->color_review ? '• ' . str_replace('||', '<br>• ', $item->color_review) : '-' !!}
        </td>

        <td style="border:1px solid #000000; vertical-align:middle;">{{ $item->remarks ?? '-' }}</td>
        <td style="border:1px solid #000000; vertical-align:middle;" align="center">
          {{ $item->creator_name ?? '-' }}
        </td>
        <td style="border:1px solid #000000; vertical-align:middle;" align="center">
          {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i:s') : '-' }}
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
