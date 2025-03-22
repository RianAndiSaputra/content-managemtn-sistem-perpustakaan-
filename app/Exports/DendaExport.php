namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DendaExport implements FromCollection, WithHeadings, WithMapping
{
    protected $dendas;
    
    public function __construct($dendas)
    {
        $this->dendas = $dendas;
    }
    
    public function collection()
    {
        return $this->dendas;
    }
    
    public function headings(): array
    {
        return [
            'Kode Denda',
            'Nama Member',
            'Tanggal Denda',
            'Jumlah Hari',
            'Total Denda',
            'Status Pembayaran',
            'Tanggal Pembayaran'
        ];
    }
    
    public function map($denda): array
    {
        return [
            $denda->kode_denda,
            $denda->peminjaman->member->nama,
            $denda->tanggal_denda->format('d-m-Y'),
            $denda->jumlah_hari,
            $denda->total_denda,
            $denda->status_pembayaran == 'lunas' ? 'Lunas' : 'Belum Lunas',
            $denda->tanggal_pembayaran ? $denda->tanggal_pembayaran->format('d-m-Y') : '-'
        ];
    }
}