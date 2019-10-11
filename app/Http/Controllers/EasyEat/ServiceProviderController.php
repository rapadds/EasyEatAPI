<?php

namespace App\Http\Controllers\EasyEat;

use App\EasyEat\ServiceProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ServiceProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $allServiceProviders = ServiceProvider::all();
        $response = array(
            "success" => true,
            'data' => $allServiceProviders,
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
            "sexe"=> "numeric",
            "dateNaissance"=> "date",
            "telephone"=> "json",
            "coordonneBancaireInJson"=> "json",
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
        $newProvider =  ServiceProvider::create(array(
            "nom" => $input['nom'],
            "prenom" => $input['prenom'],
            "sexe" => $input['sexe'],
            "dateNaissance" => $input['dateNaissance'],
            "adresse" => $input['adresse'],
            "email" => $input['email'],
            "telephone" => $input['telephone'],
            "coordonneBancaireInJson" => $input['coordonneBancaireInJson'],
            "authClientId" => $input['authClientId'],
        ));

        $response = array(
            'success' => true,
            'data' => $newProvider,
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
            $theProvider = ServiceProvider::findOrFail($id);
            $response = array(
                'success' => true,
                'data' => $theProvider,
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
            "sexe"=> "numeric",
            "dateNaissance"=> "date",
            "telephone"=> "json",
            "coordonneBancaireInJson"=> "json",
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
            $newInfoServiceProvider = ServiceProvider::findOrFail($id);

            $newInfoServiceProvider->nom = $input['nom'];
            $newInfoServiceProvider->prenom = $input['prenom'];
            $newInfoServiceProvider->sexe = $input['sexe'];
            $newInfoServiceProvider->dateNaissance = $input['dateNaissance'];
            $newInfoServiceProvider->adresse = $input['adresse'];
            $newInfoServiceProvider->email = $input['email'];
            $newInfoServiceProvider->telephone = $input['telephone'];
            $newInfoServiceProvider->coordonneBancaireInJson = $input['coordonneBancaireInJson'];
            $newInfoServiceProvider->authClientId = $input['authClientId'];
            $newInfoServiceProvider->save();


            $response = array(
                'success' => true,
                'data' => $newInfoServiceProvider,
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
            $providerToDelete = ServiceProvider::findOrFail($id);
            $idDeleted = $providerToDelete->id;
            $providerToDelete->delete();

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
