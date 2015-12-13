import React, { Component, PropTypes as T } from 'react';

const layoutStyles = {
  container: {},
  sukulainen: {
    display: 'flex',
    flexDirection: 'row',
    flexGrow: 1
  },
  heppainfo: {
    display: 'flex',
    padding: '5px',
    flexGrow: 1,
    width: '0'
  },
  heppa: {
    width: '100%'
  },
  sukuinfo: {
    display: 'flex',
    flexDirection: 'column',
    flexGrow: 1
  }
};

const borderColor = '#333';
const lookStyles = {
  container: {
    borderTop: `1px solid ${borderColor}`,
    borderLeft: `1px solid ${borderColor}`
  },
  heppainfo: {
    borderBottom: `1px solid ${borderColor}`,
    borderRight: `1px solid ${borderColor}`
  },
  sukulainen: {
    backgroundColor: 'rgba(0, 100, 0, 0.15)'
  },
  heppa: {
    textAlign: 'center'
  }
};

const styles = Object.keys(layoutStyles).reduce((endStyles, key) => ({
  ...endStyles,
  [key]: {
    ...layoutStyles[key],
    ...lookStyles[key]
  }
}), {});

class Sukulainen extends Component {
  static propTypes = {
    nimi: T.string,
    children: T.node,
    polvi: T.number.isRequired,
    pituus: T.number.isRequired
  }

  render() {
    const {nimi, children, polvi, pituus} = this.props;

    const sukuinfoTyylit = {
      ...styles.sukuinfo,
      flexGrow: pituus - polvi
    };

    return (
      <div style={styles.sukulainen}>
        <div style={styles.heppainfo}>
          <div style={styles.heppa}>
            {nimi}
          </div>
        </div>
        {children && <div style={sukuinfoTyylit}>{children}</div>}
      </div>
    );
  }
}

const suvunPituus = (sukuObj, pituus = 0) => {
  const { mother, father } = sukuObj;
  if (mother && father) {
    return Math.max(suvunPituus(mother, pituus + 1), suvunPituus(father, pituus + 1));
  }
  return pituus;
};

export default class Sukutaulu extends Component {
  render() {
    const { suku } = this.props;
    const pituus = suvunPituus(suku);

    return (
      <div style={{ overflow: 'hidden' }}>
        <div style={styles.container}>
          {this._renderHeppa(suku, pituus)}
        </div>
      </div>
    );
  }

  _renderHeppa(heppa, pituus, polvi = 0) {
    const { name: nimi, father, mother } = heppa;

    if (father && mother) {
      return (
        <Sukulainen nimi={nimi} polvi={polvi} pituus={pituus} key={nimi}>
          {this._renderHeppa(father, pituus, polvi + 1)}
          {this._renderHeppa(mother, pituus, polvi + 1)}
        </Sukulainen>
      );
    }
    else {
      return <Sukulainen nimi={nimi} polvi={polvi} pituus={pituus} key={nimi} />;
    }
  }
}
