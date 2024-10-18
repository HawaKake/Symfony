namespace App\Form\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClientFormSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
            FormEvents::PRE_SET_DATA => 'onPreSetData',
        ];
    }

    // Cette méthode est appelée avant la soumission des données
    public function onPreSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        // Exemple : Si un utilisateur particulier est sélectionné, on modifie le formulaire
        if (!empty($data['utilisateur'])) {
            $userId = $data['utilisateur'];

            // Ajouter un champ "codeClient" uniquement pour certains utilisateurs
            if ($userId == 1) {  // Exemple de condition sur l'utilisateur
                $form->add('codeClient', TextType::class, [
                    'label' => 'Code Client Spécial',
                    'required' => false,
                ]);
            }
        }
    }

    // Cette méthode est appelée lorsque le formulaire est initialisé
    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $client = $event->getData();

        // Si le formulaire est pour un client déjà existant, on peut modifier les champs ici
        if ($client && $client->getUtilisateur()) {
            $form->add('codeClient', TextType::class, [
                'label' => 'Code Client (existant)',
                'required' => false,
            ]);
        }
    }
}
