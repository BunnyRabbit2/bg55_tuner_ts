import React from "react";

export default function Navbar() {
  return (
    <nav className="navbar bg-base-100">
      <a className="btn btn-ghost normal-case text-xl">BG55 Forza Tuner</a>
      <div className="tabs">
        <a className="tab">Tuner</a>
        <a className="tab">Docs</a>
      </div>
    </nav>
  );
}
