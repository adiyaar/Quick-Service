package com.sharp_dev.customer.Extra;

import java.util.ArrayList;

import com.sharp_dev.customer.ModelClass.SavedAddress;



public interface SavedPlaceListener {
    public void onSavedPlaceClick(ArrayList<SavedAddress> mResultList, int position);
}
