package com.sharp_dev.quick_service.Adapter;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentPagerAdapter;

import com.sharp_dev.quick_service.Fragments.AllearningsFragment;
import com.sharp_dev.quick_service.Fragments.RechargeFragment;


public class EarningAdapter extends FragmentPagerAdapter {
    private int numsoftabs;

    public EarningAdapter(FragmentManager fm, int numsoftabs) {
        super(fm);
        this.numsoftabs = numsoftabs;
    }

    @NonNull
    @Override
    public Fragment getItem(int position) {
        switch (position){

            case 0 :
                return new AllearningsFragment();
            case 1:
                return new RechargeFragment();

            default:
                return null;
        }
    }

    @Override
    public int getCount() {
        return numsoftabs;
    }


}
