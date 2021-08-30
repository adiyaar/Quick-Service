package com.sharp_dev.quick_service.Adapter;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentPagerAdapter;

import com.sharp_dev.quick_service.Fragments.LoginFragment;
import com.sharp_dev.quick_service.Fragments.SignupFragment;


public class PageAdapter extends FragmentPagerAdapter {
    private int numsoftabs;


    public PageAdapter(FragmentManager fm, int numsoftabs) {
        super(fm);
        this.numsoftabs = numsoftabs;
    }

    @NonNull
    @Override
    public Fragment getItem(int position) {
        switch (position){

            case 0 :
                return new LoginFragment();
            case 1 :
                return new SignupFragment();

            default:
                return null;
        }
    }

    @Override
    public int getCount() {
        return numsoftabs;
    }


}
