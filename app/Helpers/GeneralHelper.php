<?php

function checkRequest($request)
{
    if(!$request->has('is_active')) {
        $request->request->add(['is_active' => 0]);
    } else {
        $request->request->add(['is_active' => 1]);
    }

    return $request;
}

function successMessage($actionType)
{
    return redirect()->back()->with(['success' => $actionType.'successfully']);
}

function errorMessage()
{
    return redirect()->back()->with(['error' => 'Something went wrong']);
}

function uploadPhoto($image, $folderName)
{
    $image->store('/', $folderName);
    return $image->hashName();
}
