package com.sharp_dev.quick_service.Adapter;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentPagerAdapter;

import com.sharp_dev.quick_service.Fragments.HistoryFragment;
import com.sharp_dev.quick_service.Fragments.OngoingFragment;
import com.sharp_dev.quick_service.Fragments.WithdrawlFragment;


public class JobAdapter extends FragmentPagerAdapter {
    private int numsoftabs;


    public JobAdapter(FragmentManager fm, int numsoftabs) {
        super(fm);
        this.numsoftabs = numsoftabs;

    }

    @NonNull
    @Override
    public Fragment getItem(int position) {
        switch (position){

            case 0 :
                return new OngoingFragment();
            case 1:
                return new HistoryFragment();
            case 2:
                return new WithdrawlFragment();

            default:
                return null;
        }
    }

    @Override
    public int getCount() {
        return numsoftabs;
    }


}
