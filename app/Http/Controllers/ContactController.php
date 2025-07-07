<?php

namespace App\Http\Controllers;

use App\Events\ContactCreated;
use App\Events\ContactDeleted;
use App\Events\ContactUpdated;
use App\Http\Requests\ContactsRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);

        return Inertia::render('Contacts/Index', [
            'contacts' => $contacts,
            'success' => session('success')
        ]);
    }

    public function store(ContactsRequest $request)
    {
        try {
            $data = $request->validated();
            $data['phone'] = preg_replace('/\D/', '', $data['phone']);
            $data['created_by'] = Auth::id();

            $contact = Contact::create($data);

            // Disparar evento para notificação
            event(new ContactCreated($contact));

            \Log::info('Disparando evento ContactCreated', ['contact_id' => $contact->id]);

            return redirect()->back()->with('success', 'Contato criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao criar contato: ' . $e->getMessage());
        }
    }

    public function update(ContactsRequest $request, Contact $contact)
    {
        try {
            $data = $request->validated();
            $data['phone'] = preg_replace('/\D/', '', $data['phone']);
            $data['updated_by'] = Auth::id();

            $contact->update($data);

            // Evento de atualização
            event(new ContactUpdated($contact));

            return redirect()->back()->with('success', 'Contato atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar contato: ' . $e->getMessage());
        }
    }

    public function destroy(Contact $contact)
    {
        try {
            $contactName = $contact->name;
            $contactData = $contact->toArray();
            
            // Usar o usuário que criou o contato ou o usuário atual
            $user = $contact->createdBy ?? Auth::user();

            $contact->delete();

            // Disparar evento para notificação
            event(new ContactDeleted($user, $contactName, $contactData));

            return redirect()->back()->with('success', 'Contato excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir contato: ' . $e->getMessage());
        }
    }
}