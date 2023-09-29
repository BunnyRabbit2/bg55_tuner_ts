import React from "react";

export default function Navbar() {
  return (
    <nav className="navbar bg-accent text-accent-content container mx-auto justify-between">
      <div className="pl-4 flex items-center">
        <a className="font-bold text-xl">BG55 Forza Tuner</a>
      </div>
      <div className="tabs">
        <a className="tab text-accent-content">Tuner</a>
        <a className="tab text-accent-content">Docs</a>
      </div>
    </nav>
  );
}
