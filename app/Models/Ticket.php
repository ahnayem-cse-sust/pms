<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'preferred_completion_date' => 'date',
        'due_date' => 'date',
        'approval_required' => 'boolean',
        'sla_response_due_at' => 'datetime',
        'sla_resolution_due_at' => 'datetime',
        'acknowledged_at' => 'datetime',
        'assigned_at' => 'datetime',
        'started_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
        'reopened_at' => 'datetime',
    ];

    public function type() { return $this->belongsTo(TicketType::class, 'ticket_type_id'); }
    public function requester() { return $this->belongsTo(User::class, 'requester_id'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function department() { return $this->belongsTo(Department::class); }
    public function location() { return $this->belongsTo(Location::class); }
    public function category() { return $this->belongsTo(TicketCategory::class, 'category_id'); }
    public function subcategory() { return $this->belongsTo(TicketSubcategory::class, 'subcategory_id'); }
    public function priority() { return $this->belongsTo(TicketPriority::class, 'priority_id'); }
    public function status() { return $this->belongsTo(TicketStatus::class, 'status_id'); }
    public function assignee() { return $this->belongsTo(User::class, 'assigned_to'); }
    public function comments() { return $this->hasMany(TicketComment::class)->with('user')->oldest(); }
    public function notes() { return $this->hasMany(TicketInternalNote::class)->with('user')->oldest(); }
    public function attachments() { return $this->hasMany(TicketAttachment::class)->with('uploader'); }
    public function history() { return $this->hasMany(TicketHistory::class)->with('user')->oldest('created_at'); }
    public function assignments() { return $this->hasMany(TicketAssignment::class)->with(['assignee', 'assigner']); }

    /** Row-level visibility. Applied to every list and to show(). */
    public function scopeVisibleTo($q, User $u)
    {
        if ($u->hasPermission('ticket.view.all')) {
            return $q;
        }
        return $q->where(function ($w) use ($u) {
            // the requester, and whoever filed it on their behalf
            $w->where('requester_id', $u->id)->orWhere('created_by', $u->id);
            if ($u->hasPermission('ticket.view.department') && $u->department_id) {
                $w->orWhere('department_id', $u->department_id);
            }
            if ($u->hasPermission('ticket.view.assigned')) {
                $w->orWhere('assigned_to', $u->id);
            }
        });
    }

    public function scopeOpen($q)
    {
        return $q->whereHas('status', fn ($s) => $s->where('is_open', true));
    }
}
