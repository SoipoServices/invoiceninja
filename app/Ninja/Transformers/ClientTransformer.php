<?php namespace App\Ninja\Transformers;

use App\Models\Client;
use App\Models\Contact;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class ClientTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'contacts',
        'invoices',
        'quotes',
    ];

    public function includeContacts($client)
    {
        return $this->collection($client->contacts, new ContactTransformer);
    }

    public function includeInvoices($client)
    {
        $invoices = $client->invoices->filter(function($invoice) {
            return !$invoice->is_quote && !$invoice->is_recurring;
        });
        
        return $this->collection($invoices, new InvoiceTransformer);
    }

    public function includeQuotes($client)
    {
        $invoices = $client->invoices->filter(function($invoice) {
            return $invoice->is_quote && !$invoice->is_recurring;
        });
        
        return $this->collection($invoices, new QuoteTransformer);
    }

    public function transform(Client $client)
    {
        return [
            'public_id' => (int) $client->public_id,
            'name' => $client->name,
            'balance' => (float) $client->balance,
            'paid_to_date' => (float) $client->paid_to_date,
            'user_id' => (int) $client->user_id,
            'account_key' => $client->account->account_key,
            'updated_at' => $client->updated_at,
            'deleted_at' => $client->deleted_at,
            'address1' => $client->address1,
            'address2' => $client->address2,
            'city' => $client->city,
            'state' => $client->state,
            'postal_code' => $client->postal_code,
            'country_id' => (int) $client->country_id,
            'work_phone' => $client->work_phone,
            'private_notes' => $client->private_notes,
            'balance' => (float) $client->balance,
            'paid_to_date' => $client->paid_to_date,
            'last_login' => $client->last_login,
            'website' => $client->website,
            'industry_id' => (int) $client->industry_id,
            'size_id' => (int) $client->size_id,
            'is_deleted' => (bool) $client->is_deleted,
            'payment_terms' => (int) $client->payment_terms,
            'vat_number' => $client->vat_number,
            'id_number' => $client->id_number,
            'language_id' => (int) $client->language_id
        ];
    }
}