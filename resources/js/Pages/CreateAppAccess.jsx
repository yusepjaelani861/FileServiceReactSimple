import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head } from '@inertiajs/inertia-react';
import AlpineInstance from 'alpinejs';
import axios from 'axios';

export default function AppAccess(props) {
    const submitEvent = (e) => {
        e.preventDefault();
        var name = document.getElementById("name").value;
        var domain = document.getElementById("domain").value;

        console.log(name);
        console.log(domain);

        var data = {
            name: name,
            domain: domain
        }
        
        axios('/app-access/create', {
            method: 'POST',
            data: data,
            headers: {
                'Content-Type': 'application/json'
            },
        })
        .then(function (response) {
            console.log(response);
            window.location.href = '/applist';
        })
        .catch(function (error) {
            console.log(error);
            alert('Error');
        });
    }

    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">AppAccess</h2>}
        >
            <Head title="AppAccess" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        {/* Input Text */}
                        <div className="p-6 bg-white border-b border-gray-200">
                            
                            {/* Name URL */}
                            <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="text">
                                Name
                            </label>
                            <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" />

                            {/* Domain */}
                            <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="text">
                                Domain
                            </label>
                            <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="domain" type="text" />

                            <p className="text-gray-500 text-xs italic">
                                Please enter a text.
                            </p>

                            <button className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" onClick={submitEvent}>
                                Create
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Authenticated>
    );
}
