import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head } from '@inertiajs/inertia-react';
import AlpineInstance from 'alpinejs';
import axios from 'axios';
import Alpine from 'alpinejs'
import Clipboard from "@ryangjchandler/alpine-clipboard"

Alpine.plugin(Clipboard)

export default function AppAccess(props) {
    function formatDate(date) {
        // Change format to DD MM YY HH:MM
        const d = new Date(date);
        const month = `0${d.getMonth() + 1}`.slice(-2);
        const day = `0${d.getDate()}`.slice(-2);
        const year = d.getFullYear();

        const hours = `0${d.getHours()}`.slice(-2);
        const minutes = `0${d.getMinutes()}`.slice(-2);

        return `${day}/${month}/${year}` + ` ${hours}:${minutes}`;
    }

    function AppAccessTabel() {
        const AppAccess = props.app_access;

        if (AppAccess.length > 0) {
            return (
                <tbody className="bg-gray-200 text-center">
                    {AppAccess.map(App => (
                        <tr key={App.id} className="bg-white border-4 border-gray-200">
                            <td className="border px-4 py-2">{App.name}</td>
                            <td className="border px-4 py-2">{App.url}</td>
                            <td className="border px-4 py-2 truncate flex">{App.token}</td>
                            <td className="border px-4 py-2">{formatDate(App.created_at)}</td>
                        </tr>
                    ))}
                </tbody>
            );
        } else {
            return (
                <div className="text-center">
                    <h3 className="text-gray-500">No AppAccess found.</h3>
                </div>
            );
        }
        
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
                <div className="text-right mb-4 text-white">
                        <a href="/create-app" className="bg-blue-600 rounded-md shadow-sm py-2 px-2 font-semibold hover:bg-blue-800">
                            Add AppAccess
                        </a>
                    </div>
                    <div className="overflow-auto">
                        <table className="min-w-full table-auto">
                            <thead className="justify-between">
                            <tr className="bg-gray-800">
                                <th className="px-16 py-2">
                                    <span className="text-gray-300">Name</span>
                                </th>

                                <th className="px-16 py-2">
                                    <span className="text-gray-300">Domain</span>
                                </th>

                                <th className="px-16 py-2">
                                    <span className="text-gray-300">Token</span>
                                </th>

                                <th className="px-16 py-2">
                                    <span className="text-gray-300">Created At</span>
                                </th>
                            </tr>
                            </thead>

                            {/* Add Isi Tabel */}
                            {AppAccessTabel()}
                        </table>
                    </div>
                </div>
            </div>
        </Authenticated>
    );
}
