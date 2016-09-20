<?php
namespace Topix\Hackademy\ContactToolSdk\Test;

Use Topix\Hackademy\ContactToolSdk\Contact\Facades\ContactTool ;
Use Topix\Hackademy\ContactToolSdk\test\User ;
Use Topix\Hackademy\ContactToolSdk\Api\Entities\Contact ;
Use GuzzleHttp\Psr7\Response ;

class ContactToolClassTest extends TestCase {

    public $newUserEmail = 'auto-d-user@gmail.com';
    public $newUserData = [
        "contact_username"=> "auto-d-user",
        "contact_first_name"=> "iiiiiiii",
        "contact_last_name"=> "iiiiiiii",
        "contact_email"=> "auto-d-user@gmail.com",
        "contact_phone"=> "312382892",
        "contact_notes"=> "",
        "role"=> [
            "relations"=> [
                [
                    "company"=>
                        [
                            "id"=> 1,
                        ],
                    "role"=> "tech"
                ]
            ]
        ]
    ];

    public function test_should_log (){
        $this->log('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx test');
    }

    // API

    public function test_API_should_get_users_list(){

        $contactList = Contact::all();

        if( $contactList instanceof Response) $this->assertTrue(false);
        else $this->assertTrue(true);

    }

    public function test_API_should_get_user_by_id(){

        $contact = Contact::get(1);
        $this->log($contact);

        if( $contact instanceof Response) $this->assertTrue(false);
        else $this->assertTrue(true);

    }

    public function test_API_should_create_user(){

        $contact = Contact::create($this->newUserData);

        if( $contact instanceof Response){
            $this->log($contact->getBody()->getContents());
        }
        else
            $this->log($contact);

    }

    // Referable
    public function test_should_not_create_an_user_when_data_is_empty (){

        $user = new User();

        $response = ContactTool::createContact($user, []);

        $this->assertTrue( $response instanceof Response );

    }

    /**
     * @test
     */
    public function test_should_create_an_user (){

        $user = new User();

        $user->email = $this->newUserData['contact_email'];
        $user->name = $this->newUserData['contact_first_name'].' '.$this->newUserData['contact_last_name'];
        $user->uid = $this->newUserData['contact_username'].' '.$this->newUserData['username'];

        $user->save();

        $user->referenceType = 'contact';

        $this->newUserData['contact_username'] = $this->newUserData['contact_username'].'2' ;

        // Create reference
        $newReference = $user->createReference($this->newUserData);

        // Get reference
        $userExistOnRemote = ContactTool::getContactByEmail( $this->newUserEmail );

        $this->assertTrue( ! $userExistOnRemote instanceof Response );

        // Delete user
        $user->delete();

    }

    /**
     * @test
     */
    public function should_create_an_user_that_doesnt_exist_on_both (){

        $this->newUserData['contact_username'] = $this->newUserData['contact_username'].'3' ;
        $this->newUserData['contact_email'] = 'auto-d-user@gmail.com' ;

        // Create Local user
        $user = new User();
        $user->email = $this->newUserData['contact_email'];
        $user->name = $this->newUserData['contact_first_name'].' '.$this->newUserData['contact_last_name'];
        $user->uid = $this->newUserData['contact_username'].' '.$this->newUserData['username'];

        $user->save();


        $user->referenceType = 'contact';

        $newReference = $user->createReference($this->newUserData);

        $this->assertTrue( $newReference && ! $newReference instanceof Response );

        $reference = $user->getReference();
        $this->assertTrue( $newReference && ! $reference instanceof Response );

        $modifiedData = $this->newUserData->contact_first_name = 'zszszzssszssszs';

        $userUpdated = $user->updateReference( $modifiedData );

        $this->assertTrue( $newReference && ! $userUpdated instanceof Response );

        // Delete user
        $user->delete();

    }

    /**
     * @test
     */
    public function should_create_a_local_user_if_is_already_on_remote (){

        // Create Local user
        $user = new User();
        $user->email = $this->newUserData['contact_email'];
        $user->name = $this->newUserData['contact_first_name'].' '.$this->newUserData['contact_last_name'];
        $user->uid = $this->newUserData['contact_username'].' '.$this->newUserData['username'];

        $user->save();

        $response = ContactTool::createContact($user, $this->newUserData);

        $this->assertTrue($response && $response instanceof Response );

        // Delete user
        $user->delete();

    }

    public function log($logMe){
        fwrite(STDERR, print_r(' - ', TRUE));
        fwrite(STDERR, print_r($logMe, TRUE));
        fwrite(STDERR, print_r(' - ', TRUE));
    }
    
    
}