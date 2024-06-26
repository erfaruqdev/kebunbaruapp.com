<?php

namespace App\Livewire\RegisterManagement\Status;

use App\Models\RegisterManagement\Registration;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    public $search = null;
    public $status;
    use WithPagination;
    public function placeholder(): string
    {
        return <<<'HTML'
        <div>
            <div class="d-flex align-items-center pt-6 text-muted">
                <span>Data sedang dimuat...</span>
                <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
            </div>
        </div>
        HTML;
    }

    #[On('success-created')]
    public function render(): View
    {
        $statuses = Registration::query()->withWhereHas('student', function ($query) {
            $query->when($this->search, function ($query, $search){
                $query->whereAny(['id', 'nik', 'name'], 'like', '%'.$search.'%');
            })->when($this->status != '', function (Builder $builder){
                $builder->where('status', $this->status);
            });
        })->orderBy('updated_at', 'desc')->paginate(12);

        return view('livewire.register-management.status.index', [
            'statuses' => $statuses
        ]);
    }

    public function updating($key): void
    {
        if ($key === 'search' || $key === 'status') {
            $this->resetPage();
        }
    }
}
