package com.sharp_dev.customer;

import static com.sharp_dev.customer.Extra.Config.GET_CITY_BOUNDRIES;

import android.Manifest;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.AppCompatButton;
import androidx.cardview.widget.CardView;
import androidx.core.app.ActivityCompat;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.sharp_dev.Session_management;
import com.sharp_dev.customer.Adapter.PlaceAutocompleteAdapter;
import com.sharp_dev.customer.Extra.SavedPlaceListener;
import com.sharp_dev.customer.ModelClass.SavedAddress;
import com.sharp_dev.quick_service.R;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.common.api.PendingResult;
import com.google.android.gms.common.api.Status;
import com.google.android.gms.location.LocationListener;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.LatLngBounds;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.net.URLEncoder;
import java.text.DateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Locale;


public class LocationActivity extends AppCompatActivity implements
        LocationListener, PlaceAutocompleteAdapter.PlaceAutoCompleteInterface,
        GoogleApiClient.ConnectionCallbacks,
        GoogleApiClient.OnConnectionFailedListener, View.OnClickListener, SavedPlaceListener {

    private static final String TAG = "LocationActivity";
    private static final long INTERVAL = 1000 * 1000;
    private static final long FASTEST_INTERVAL = 1000 * 5000;
    Button btnFusedLocation;
    EditText tvLocation;
    LocationRequest mLocationRequest;
    GoogleApiClient mGoogleApiClient;
    Location mCurrentLocation;
    String mLastUpdateTime;
    LinearLayout detect;
    ImageView back_img;
    private RecyclerView mRecyclerView;
    LinearLayoutManager llm;
    PlaceAutocompleteAdapter mAdapter;
    List<SavedAddress> mSavedAddressList;
    private static LatLngBounds BOUNDS_PAKISTAN;


    String lat, lng;
    AppCompatButton saved;

    String latNorth, lngNorth, latSouth, lngSouth;

    Button close_places;
    ImageView mClear;

    SharedPreferences placePref;
    SharedPreferences.Editor editor;
    String city_name;
    int PLACE_AUTOCOMPLETE_REQUEST_CODE = 1;
    Session_management sessionManagement;
    CardView cardview;

    protected void createLocationRequest() {
        mLocationRequest = new LocationRequest();
        mLocationRequest.setInterval(INTERVAL);
        mLocationRequest.setFastestInterval(FASTEST_INTERVAL);
        mLocationRequest.setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        getWindow().setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_STATE_HIDDEN);

        if (!isGooglePlayServicesAvailable()) {
            finish();
        }
        createLocationRequest();
        placePref = getSharedPreferences("getlatlng", MODE_PRIVATE);


        city_name = "Noida";
        editor = placePref.edit();


        mGoogleApiClient = new GoogleApiClient.Builder(this)
                .addApi(LocationServices.API)
                .addConnectionCallbacks(this)
                .addOnConnectionFailedListener(this)
                .build();
        setContentView(R.layout.activity_location);

        sessionManagement=new Session_management(this);

        tvLocation = findViewById(R.id.et_location);
        cardview = findViewById(R.id.cardview);
        saved = findViewById(R.id.saved);
        detect = findViewById(R.id.detect);

        mClear = findViewById(R.id.clear);
        back_img=findViewById(R.id.back_img);

        mClear.setOnClickListener(v -> {
            if(v == mClear){
                tvLocation.setText("");
                if(mAdapter!=null){
                    mAdapter.clearList();
                }

            }
        });

        back_img.setOnClickListener(v -> onBackPressed());

        lat = placePref.getString("getlat", "");
        lng = placePref.getString("getlng", "");


        if (lat.contains("")) {

            tvLocation.setHint("Search Location");
        } else {
            Geocoder gcd = new Geocoder(LocationActivity.this, Locale.getDefault());

            List<Address> addresses = null;
            try {
                addresses = gcd.getFromLocation(Double.parseDouble(lat), Double.parseDouble(lng), 1);
            } catch (IOException e) {
                e.printStackTrace();
            }
            if (addresses != null && addresses.size() > 0) {
                String locality = addresses.get(0).getAddressLine(0);
                tvLocation.setText(locality);


            }

        }


        detect.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                updateUI();
            }
        });
        getLatlngBounds();

        saved.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(LocationActivity.this, HomePageActivity.class);
                startActivity(intent);

                editor.putString("getlat", lat);
                editor.putString("getlng", lng);
                editor.putString("value", "true");
                sessionManagement.LatLng(lat,lng);
                editor.commit();

            }
        });
    }

    @Override
    public void onStart() {
        super.onStart();
        Log.d(TAG, "onStart fired ..............");
        mGoogleApiClient.connect();
    }

    @Override
    public void onStop() {
        super.onStop();
        Log.d(TAG, "onStop fired ..............");
        mGoogleApiClient.disconnect();
        Log.d(TAG, "isConnected ...............: " + mGoogleApiClient.isConnected());
    }

    private boolean isGooglePlayServicesAvailable() {
        int status = GooglePlayServicesUtil.isGooglePlayServicesAvailable(this);
        if (ConnectionResult.SUCCESS == status) {
            return true;
        } else {
            GooglePlayServicesUtil.getErrorDialog(status, this, 0).show();
            return false;
        }
    }

    @Override
    public void onConnected(Bundle bundle) {
        Log.d(TAG, "onConnected - isConnected ...............: " + mGoogleApiClient.isConnected());
        startLocationUpdates();
    }

    protected void startLocationUpdates() {
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {

            return;
        }
        PendingResult<Status> pendingResult = LocationServices.FusedLocationApi.requestLocationUpdates(
                mGoogleApiClient, mLocationRequest, this);
        Log.d(TAG, "Location update started ..............: ");
    }

    @Override
    public void onConnectionSuspended(int i) {

    }

    @Override
    public void onConnectionFailed(ConnectionResult connectionResult) {
        Log.d(TAG, "Connection failed: " + connectionResult.toString());
    }

    @Override
    public void onLocationChanged(Location location) {
        Log.d(TAG, "Firing onLocationChanged..............................................");
        mCurrentLocation = location;
        mLastUpdateTime = DateFormat.getTimeInstance().format(new Date());
        updateUI();
    }

    private void updateUI() {
        Log.d(TAG, "UI update initiated .............");
        if (null != mCurrentLocation) {
             lat = String.valueOf(mCurrentLocation.getLatitude());
             lng = String.valueOf(mCurrentLocation.getLongitude());
            editor.putString("getlat",lat);
            editor.putString("getlng",lng);
            editor.putString("value","true");
            editor.commit();

            Geocoder gcd = new Geocoder(LocationActivity.this, Locale.getDefault());

            List<Address> addresses = null;
            try {
                addresses = gcd.getFromLocation(Double.parseDouble(lat), Double.parseDouble(lng) , 1);
            } catch (IOException e) {
                e.printStackTrace();
            }
            if (addresses != null && addresses.size() > 0) {
               String locality = addresses.get(0).getAddressLine(0);

               tvLocation.setText(locality);
            }


        } else {
            Log.d(TAG, "location is null ...............");
        }
    }

    @Override
    protected void onPause() {
        super.onPause();
        stopLocationUpdates();
    }

    protected void stopLocationUpdates() {
        LocationServices.FusedLocationApi.removeLocationUpdates(
                mGoogleApiClient, this);
        Log.d(TAG, "Location update stopped .......................");
    }

    @Override
    public void onResume() {
        super.onResume();
        if (mGoogleApiClient.isConnected()) {
            startLocationUpdates();
            Log.d(TAG, "Location update resumed .....................");
        }
    }
    public void getLatlngBounds(){

        String finalCityName = city_name.replaceAll(" ","%20");
        RequestQueue requestQueue = Volley.newRequestQueue(LocationActivity.this);

        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest(Request.Method.GET, GET_CITY_BOUNDRIES+finalCityName,null, new Response.Listener<JSONObject>() {
            @Override
            public void onResponse(JSONObject response) {

                try {
                    JSONObject jsonObject = new JSONObject(String.valueOf(response));

                    JSONArray jsonArray = jsonObject.getJSONArray("results");

                    for (int i =0;i<jsonArray.length();i++) {

                        JSONObject jsonObject1 = jsonArray.getJSONObject(i);

                        JSONObject geometry = jsonObject1.getJSONObject("geometry");
                        JSONObject bounds = geometry.getJSONObject("bounds");
                        JSONObject northeast = bounds.getJSONObject("northeast");
                        JSONObject southwest = bounds.getJSONObject("southwest");
                        try {
                            latNorth = northeast.optString("lat").trim();
                            lngNorth = northeast.optString("lng").trim();

                            latSouth = southwest.optString("lat").trim();
                            lngSouth = southwest.optString("lng").trim();


                            BOUNDS_PAKISTAN = new LatLngBounds(
                                    new LatLng(Double.parseDouble(latSouth), Double.parseDouble(lngSouth)),
                                    new LatLng(Double.parseDouble(latNorth), Double.parseDouble(lngNorth)));
                        } catch (Exception e){
                            e.getCause();
                        }

                    }

                    initViews();

                } catch (JSONException e) {
                    e.printStackTrace();
                }


            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        });

        requestQueue.add(jsonObjectRequest);

    }



    private void initViews(){

        mRecyclerView = (RecyclerView)findViewById(R.id.list_search);
        mRecyclerView.setHasFixedSize(true);
        llm = new LinearLayoutManager(this);
        mRecyclerView.setLayoutManager(llm);

        mAdapter = new PlaceAutocompleteAdapter(this, R.layout.row_item_view_placesearch,
                mGoogleApiClient, BOUNDS_PAKISTAN, null);

        mRecyclerView.setAdapter(mAdapter);

        tvLocation.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                if (count > 0) {
                    mClear.setVisibility(View.VISIBLE);
                    if (mAdapter != null) {
                        mRecyclerView.setAdapter(mAdapter);
                    }
                } else {
                    mClear.setVisibility(View.GONE);

                }
                if (!s.toString().equals("") && mGoogleApiClient.isConnected()) {
                    mAdapter.getFilter().filter(s.toString());
                } else if (!mGoogleApiClient.isConnected()) {
                    Log.e("", "NOT CONNECTED");
                }
            }

            @Override
            public void afterTextChanged(Editable s) {

            }
        });

    }





    @Override
    public void onPlaceClick(ArrayList<PlaceAutocompleteAdapter.PlaceAutocomplete> mResultList, int position) {
        if(mResultList!=null){
            try {
                final String placeId = String.valueOf(mResultList.get(position).placeId);

                StringBuilder stringBuilder=new StringBuilder();
                stringBuilder.append("https://maps.googleapis.com/maps/api/place/details/json?placeid=");
                stringBuilder.append(URLEncoder.encode(placeId, "utf8"));
                stringBuilder.append("&key=");
                stringBuilder.append(getResources().getString(R.string.place_map_key));



                RequestQueue rq = Volley.newRequestQueue(this);
                JsonObjectRequest jsonObjectRequest = new JsonObjectRequest
                        (Request.Method.GET, stringBuilder.toString(), null, new Response.Listener<JSONObject>() {

                            @Override
                            public void onResponse(JSONObject jsonResults) {
                                String respo=jsonResults.toString();
                                Log.d("responce",respo);

                                JSONObject jsonObj = null;
                                try {
                                    jsonObj = new JSONObject(jsonResults.toString());

                                    Log.d("resp",jsonResults.toString());
                                    JSONObject result = jsonObj.getJSONObject("result");
                                    JSONObject geometry = result.getJSONObject("geometry");
                                    JSONObject location = geometry.getJSONObject("location");


                                    Intent data = new Intent();


                                    lat= String.valueOf(location.opt("lat"));
                                    lng= String.valueOf(location.opt("lng"));
                                    editor.putString("getlat", String.valueOf(location.opt("lat")));
                                    editor.putString("getlng", String.valueOf(location.opt("lng")));
                                    editor.putString("value","true");
                                    editor.commit();

                                    Geocoder gcd = new Geocoder(LocationActivity.this, Locale.getDefault());

                                    List<Address> addresses = null;
                                    try {
                                        addresses = gcd.getFromLocation(Double.parseDouble(lat), Double.parseDouble(lng) , 1);
                                    } catch (IOException e) {
                                        e.printStackTrace();
                                    }
                                    if (addresses != null && addresses.size() > 0) {
                                        String locality = addresses.get(0).getAddressLine(0);
                                        tvLocation.setText(locality);


                                    }


                                    data.putExtra("lat", String.valueOf(location.opt("lat")));
                                    data.putExtra("lng", String.valueOf(location.opt("lng")));
                                    setResult(RESULT_OK, data);
                                } catch (JSONException e) {
                                    e.printStackTrace();
                                }

                            }
                        }, new Response.ErrorListener() {
                            @Override
                            public void onErrorResponse(VolleyError error) {
                                Log.d("respoeee",error.toString());
                            }
                        });
                jsonObjectRequest.setRetryPolicy(new DefaultRetryPolicy(30000,
                        DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                        DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
                rq.getCache().clear();
                rq.add(jsonObjectRequest);

            }
            catch (Exception e){

            }

        }
    }

    @Override
    public void onSavedPlaceClick(ArrayList<SavedAddress> mResultList, int position) {
        if(mResultList!=null){
            try {
                Intent data = new Intent();
                data.putExtra("lat", String.valueOf(mResultList.get(position).getLatitude()));
                data.putExtra("lng", String.valueOf(mResultList.get(position).getLongitude()));
                setResult(LocationActivity.RESULT_OK, data);
                finish();

            }
            catch (Exception e){

            }

        }
    }

    @Override
    public void onPointerCaptureChanged(boolean hasCapture) {

    }

    @Override
    public void onClick(View v) {

    }
}
