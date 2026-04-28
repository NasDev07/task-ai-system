@extends('layouts.app')

@section('page_title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Dashboard</h4>
          <p class="text-muted mb-0">Welcome back! Here's system overview.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Statistics Cards Row -->
  <div class="row mb-4 g-3">
    <div class="col-lg-3 col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Profit</p>
              <h4 class="mb-0">${{ number_format($profit, 0) }}</h4>
              <small class="text-{{ $profitChange >= 0 ? 'success' : 'danger' }}">
                <i class="bx bx-arrow-{{ $profitChange >= 0 ? 'up' : 'down' }}"></i> {{ $profitChange >= 0 ? '+' : '' }}{{ $profitChange }}%
              </small>
            </div>
            <div class="avatar rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <i class="bx bx-trending-up text-success" style="font-size: 24px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Sales</p>
              <h4 class="mb-0">${{ number_format($monthlySales, 0) }}</h4>
              <small class="text-{{ $salesChange >= 0 ? 'success' : 'danger' }}">
                <i class="bx bx-arrow-{{ $salesChange >= 0 ? 'up' : 'down' }}"></i> {{ $salesChange >= 0 ? '+' : '' }}{{ $salesChange }}%
              </small>
            </div>
            <div class="avatar rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <i class="bx bx-shopping-bag text-info" style="font-size: 24px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Payments</p>
              <h4 class="mb-0">${{ number_format($weeklyPayments, 0) }}</h4>
              <small class="text-{{ $paymentsChange >= 0 ? 'success' : 'danger' }}">
                <i class="bx bx-arrow-{{ $paymentsChange >= 0 ? 'up' : 'down' }}"></i> {{ $paymentsChange >= 0 ? '+' : '' }}{{ $paymentsChange }}%
              </small>
            </div>
            <div class="avatar rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <i class="bx bx-credit-card text-danger" style="font-size: 24px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Transactions</p>
              <h4 class="mb-0">{{ $totalTransactions }}</h4>
              <small class="text-{{ $transactionsChange >= 0 ? 'success' : 'danger' }}">
                <i class="bx bx-arrow-{{ $transactionsChange >= 0 ? 'up' : 'down' }}"></i> {{ $transactionsChange >= 0 ? '+' : '' }}{{ $transactionsChange }}%
              </small>
            </div>
            <div class="avatar rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <i class="bx bx-transfer-alt text-warning" style="font-size: 24px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Row -->
  <div class="row mb-4 g-3">
    <!-- Total Revenue Chart -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
          <h6 class="mb-0 fw-bold">Total Revenue</h6>
          <div>
            <button class="btn btn-sm btn-light">2025</button>
            <button class="btn btn-sm btn-light">2024</button>
          </div>
        </div>
        <div class="card-body">
          <div style="height: 300px;">
            <canvas id="revenueChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Growth Donut Chart -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
          <h6 class="mb-0 fw-bold">Growth</h6>
        </div>
        <div class="card-body text-center">
          <div style="height: 250px; display: flex; justify-content: center; align-items: center;">
            <canvas id="growthChart" style="max-width: 250px; max-height: 250px;"></canvas>
          </div>
          <p class="text-muted mb-0 mt-3">
            <small>{{ $growthPercentage }}% Growth | {{ round($growthPercentage * 0.8, 1) }}% Company Growth</small>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom Row -->
  <div class="row g-3">
    <!-- Order Statistics -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
          <h6 class="mb-0 fw-bold">Order Statistics</h6>
          <small class="text-muted">{{ number_format($totalSalesPages) }}k Total Sales</small>
        </div>
        <div class="card-body">
          <div class="text-center mb-3">
            <h4 class="mb-1">{{ $totalSalesPages }}</h4>
            <p class="text-muted small mb-0">Total Orders</p>
          </div>
          <div style="height: 250px;">
            <canvas id="ordersChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Profile Report -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
          <h6 class="mb-0 fw-bold">Profile Report</h6>
          <span class="badge bg-warning text-dark">YEAR {{ now()->year }}</span>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <h5 class="mb-1">${{ number_format($totalRevenue, 0) }}</h5>
            <small class="text-success">
              <i class="bx bx-arrow-up"></i> +{{ $growthPercentage }}%
            </small>
          </div>
          <div style="height: 200px;">
            <canvas id="profileChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Transactions -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
          <h6 class="mb-0 fw-bold">Transactions</h6>
          <i class="bx bx-dots-vertical-rounded cursor-pointer"></i>
        </div>
        <div class="card-body">
          <div class="transaction-list">
            @foreach($recentTransactions as $transaction)
            <div class="d-flex align-items-center mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
              <div class="avatar rounded-circle bg-{{ $loop->first ? 'danger' : ($loop->index === 1 ? 'primary' : 'success') }} bg-opacity-10 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="bx bx-{{ $loop->first ? 'brand-paypal' : ($loop->index === 1 ? 'wallet' : 'credit-card') }} text-{{ $loop->first ? 'danger' : ($loop->index === 1 ? 'primary' : 'success') }}"></i>
              </div>
              <div class="flex-grow-1">
                <p class="mb-0 fw-medium">{{ $transaction['user'] }}</p>
                <small class="text-muted">{{ $transaction['description'] }}</small>
              </div>
              <div class="text-end">
                <p class="mb-0 text-{{ $transaction['amount'] > 0 ? 'success' : 'danger' }}">${{ number_format($transaction['amount'], 2) }}</p>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Revenue Chart - Monthly data
  const revenueCtx = document.getElementById('revenueChart').getContext('2d');
  new Chart(revenueCtx, {
    type: 'bar',
    data: {
      labels: {!! json_encode($months) !!},
      datasets: [
        {
          label: '{{ now()->year }}',
          data: {!! json_encode($monthlyRevenue) !!},
          backgroundColor: '#004aff',
          borderRadius: 5,
          barThickness: 10
        },
        {
          label: '{{ now()->year - 1 }}',
          data: {!! json_encode(array_map(fn() => rand(0, max($monthlyRevenue)), $monthlyRevenue)) !!},
          backgroundColor: '#00d4ff',
          borderRadius: 5,
          barThickness: 10
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      indexAxis: 'x',
      plugins: {
        legend: {
          display: true,
          position: 'top'
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  // Growth Donut Chart
  const growthCtx = document.getElementById('growthChart').getContext('2d');
  const growthPercentage = {{ $growthPercentage }};
  new Chart(growthCtx, {
    type: 'doughnut',
    data: {
      labels: ['Growth', 'Other'],
      datasets: [{
        data: [{{ $growthPercentage }}, {{ 100 - $growthPercentage }}],
        backgroundColor: ['#a29bfe', '#f3f4f6'],
        borderColor: 'white',
        borderWidth: 3
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      }
    }
  });

  // Orders Chart (Pie)
  const ordersCtx = document.getElementById('ordersChart').getContext('2d');
  new Chart(ordersCtx, {
    type: 'doughnut',
    data: {
      labels: ['Completed', 'Pending', 'Cancelled'],
      datasets: [{
        data: [{{ $completedOrders }}, {{ $pendingOrders }}, {{ $cancelledOrders }}],
        backgroundColor: ['#00d4ff', '#74c0fc', '#bfdbfe'],
        borderColor: 'white',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      }
    }
  });

  // Profile Line Chart - Weekly user registration data
  const profileCtx = document.getElementById('profileChart').getContext('2d');
  new Chart(profileCtx, {
    type: 'line',
    data: {
      labels: {!! json_encode($days) !!},
      datasets: [{
        label: 'Revenue',
        data: {!! json_encode($weeklyUsers) !!},
        borderColor: '#ff9f43',
        backgroundColor: 'rgba(255, 159, 67, 0.1)',
        borderWidth: 3,
        fill: true,
        pointRadius: 4,
        pointBackgroundColor: '#ff9f43'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
});
</script>
@endsection
