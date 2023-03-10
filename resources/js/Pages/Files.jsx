import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head } from '@inertiajs/inertia-react';
import axios from 'axios';

export default function Files(props) {
    function size(bytes) {
        if (bytes < 1024) {
            return bytes + ' bytes';
        } else if (bytes < 1048576) {
            return (bytes / 1024).toFixed(2) + ' KB';
        } else if (bytes < 1073741824) {
            return (bytes / 1048576).toFixed(2) + ' MB';
        } else {
            return (bytes / 1073741824).toFixed(2) + ' GB';
        }
    }

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

    const handleChange = (e) => {
        setId(e.target.value);
    }

    const handleSubmit = (e) => {
        e.preventDefault();

        var value = e.target.value;

        const formData = new FormData();

        formData.append('id', value);

        axios.post('/delete', formData)
            .then(function (response) {
                console.log(response);
                window.location.reload();
            })
            .catch(function (error) {
                console.log(error);
            });
    }
        
    

    function isiTabel() {
        const files = props.files;
        if (files.length > 0) {
            return (
                <tbody className="bg-gray-200 text-center">
                    {files.map(file => (
                        <tr key={file.id} className="bg-white border-4 border-gray-200">
                            <td className="border px-4 py-2">{file.name}</td>
                            <td className="border px-4 py-2">{size(file.size)}</td>
                            <td className="border px-4 py-2">{formatDate(file.created_at)}</td>
                            <td className="px-16 py-2 flex">
                                <a href={'/download/' + file.file_id} className="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Download
                                </a>
                                <div>
                                    <button onClick={handleSubmit} value={file.file_id} className="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Delete
                                    </button>
                                </div>
                                </td>
                        </tr>
                    ))}
                </tbody>
            );
        } else {
            return (
                <div className="text-center">
                    <h3 className="text-gray-500">No files found.</h3>
                </div>
            );
        }
    }

    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Files</h2>}
        >
            <Head title="Files" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div className="overflow-auto">
                        <table className="min-w-full table-auto">
                            <thead className="justify-between">
                            <tr className="bg-gray-800">
                                <th className="px-16 py-2">
                                <span className="text-gray-300">File Name</span>
                                </th>

                                <th className="px-16 py-2">
                                <span className="text-gray-300">Size</span>
                                </th>

                                <th className="px-16 py-2">
                                <span className="text-gray-300">Uploaded At</span>
                                </th>

                                <th className="px-16 py-2">
                                <span className="text-gray-300">Status</span>
                                </th>
                            </tr>
                            </thead>

                            {/* Add Isi Tabel */}
                            {isiTabel()}
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </Authenticated>
    );
}
