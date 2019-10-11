<?php

namespace App\Http\Controllers\EasyEat;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EasyEat\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $allClients = Client::all();
        $response = array(
            "success" => true,
            'data' => $allClients,
            'message' => 'Users\'s info grabbed successfully.'
        );

        return response()->json($response,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validators = Validator::make($request->all(),array(
            "nom"=> "alpha_num",
            "sexe"=> "numeric",
            "dateNaissance"=> "date",
            "telephone"=> "json",
            "lieuDeResidence"=> "alpha_num",
            "socialAccountInJson"=> "json",
            "authClientId"=> "numeric|unique:clients,authClientId",
        ));

        if($validators->fails()){
            $response = array(
                "success" => false,
                "data"=> "Validation Error",
                "message" => $validators->errors()
            );

            return response()->json($response,400);
        }
        $input = $request->all();
        $newClient =  Client::create(array(
                "nom" => $input['nom'],
                "prenom" => $input['prenom'],
                "sexe" => $input['sexe'],
                "dateNaissance" => $input['dateNaissance'],
                "telephone" => $input['telephone'],
                "lieuDeResidence" => $input['lieuDeResidence'],
                "socialAccountInJson" => $input['socialAccountInJson'],
                "authClientId" => $input['authClientId'],
        ));

        $response = array(
            'success' => true,
            'data' => $newClient,
            'message' => 'User\'info saved successfully.'
        );
        return response()->json($response,200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        try{
            $theClient = Client::findOrFail($id);
            $response = array(
                'success' => true,
                'data' => $theClient,
                'message' => 'Request successfull.'
            );
            return response()->json($response,200);
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            $response = array(
                "success" => false,
                "data"=> "",
                "message" => "Requested data not found"
            );

            return response()->json($response,404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validators = Validator::make($request->all(),array(
            "nom"=> "alpha_num",
            "sexe"=> "numeric",
            "dateNaissance"=> "date",
            "telephone"=> "json",
            "lieuDeResidence"=> "alpha_num",
            "socialAccountInJson"=> "json",
        ));

        if($validators->fails()){
            $response = array(
                "success" => false,
                "data"=> "Validation Error",
                "message" => $validators->errors()
            );

            return response()->json($response,400);
        }
        $input = $request->all();
        try{
            $newInfoClient = Client::findOrFail($id);

            $newInfoClient->nom = $input['nom'];
            $newInfoClient->prenom = $input['prenom'];
            $newInfoClient->sexe = $input['sexe'];
            $newInfoClient->dateNaissance = $input['dateNaissance'];
            $newInfoClient->telephone = $input['telephone'];
            $newInfoClient->lieuDeResidence = $input['lieuDeResidence'];
            $newInfoClient->socialAccountInJson = $input['socialAccountInJson'];
            $newInfoClient->authClientId = $input['authClientId'];
            $newInfoClient->save();


            $response = array(
                'success' => true,
                'data' => $newInfoClient,
                'message' => 'User\'info saved successfully.'
            );
            return response()->json($response,200);
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            $response = array(
                "success" => false,
                "data"=> "",
                "message" => "Requested data not found"
            );

            return response()->json($response,404);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try{
            $clientToDelete = Client::findOrFail($id);
            $idDeleted = $clientToDelete->id;
            $clientToDelete->delete();

            $response = array(
                'success' => true,
                'data' => $idDeleted,
                'message' => 'User\'info deleted successfully.'
            );
            return response()->json($response,200);
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            $response = array(
                "success" => false,
                "data"=> "",
                "message" => "Requested data not found"
            );

            return response()->json($response,404);
        }


    }
}
