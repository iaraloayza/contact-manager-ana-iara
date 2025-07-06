<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactsRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
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
            
            Contact::create($data);
            
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
            
            $contact->update($data);
            
            return redirect()->back()->with('success', 'Contato atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar contato: ' . $e->getMessage());
        }
    }

    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
            
            return redirect()->back()->with('success', 'Contato excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir contato: ' . $e->getMessage());
        }
    }
}