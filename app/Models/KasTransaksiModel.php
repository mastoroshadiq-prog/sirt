<?php

namespace App\Models;

use CodeIgniter\Model;

class KasTransaksiModel extends Model
{
    protected $table = 'kas_transaksi';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'tanggal',
        'jenis',
        'kategori',
        'uraian',
        'masuk',
        'keluar',
        'saldo',
        'user_id',
        'bukti_file',
        'ref_type',
        'ref_id'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'tanggal' => 'required|valid_date',
        'jenis' => 'required|in_list[masuk,keluar]',
        'uraian' => 'required|min_length[3]',
    ];

    /**
     * Get current saldo
     */
    public function getSaldoKas(): float
    {
        $lastTransaction = $this->orderBy('id', 'DESC')->first();
        return $lastTransaction ? (float)$lastTransaction['saldo'] : 0;
    }

    /**
     * Add transaction with auto saldo calculation
     */
    public function addTransaction(array $data): bool
    {
        $currentSaldo = $this->getSaldoKas();
        
        if ($data['jenis'] === 'masuk') {
            $newSaldo = $currentSaldo + $data['masuk'];
        } else {
            $newSaldo = $currentSaldo - $data['keluar'];
        }
        
        $data['saldo'] = $newSaldo;
        $data['user_id'] = session()->get('user_id');
        
        return $this->insert($data);
    }

    /**
     * Get transactions by date range
     */
    public function getTransactionsByDateRange(string $start, string $end)
    {
        return $this->where('tanggal >=', $start)
                    ->where('tanggal <=', $end)
                    ->orderBy('tanggal', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }

    /**
     * Get monthly summary
     */
    public function getMonthlySummary(int $month, int $year): array
    {
        $start = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01";
        $end = date('Y-m-t', strtotime($start));
        
        $transactions = $this->getTransactionsByDateRange($start, $end);
        
        $masuk = 0;
        $keluar = 0;
        
        foreach ($transactions as $t) {
            $masuk += (float)$t['masuk'];
            $keluar += (float)$t['keluar'];
        }
        
        return [
            'total_masuk' => $masuk,
            'total_keluar' => $keluar,
            'transactions' => $transactions
        ];
    }

    /**
     * Get saldo trend for last N months
     */
    public function getSaldoTrend(int $months = 12): array
    {
        $data = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = date('Y-m-t', strtotime("-$i months"));
            $lastTrx = $this->where('tanggal <=', $date)
                           ->orderBy('id', 'DESC')
                           ->first();
            
            $data[] = [
                'month' => date('M Y', strtotime($date)),
                'saldo' => $lastTrx ? (float)$lastTrx['saldo'] : 0
            ];
        }
        return $data;
    }
}
