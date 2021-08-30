package com.sharp_dev.customer.fragment;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.fragment.app.Fragment;

import com.sharp_dev.quick_service.R;

public class SlideOneFragment extends Fragment {

    private  View view;




    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        view =  inflater.inflate(R.layout.slide_one, container, false);






        return  view;
    }


    }

